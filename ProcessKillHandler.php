<?php

namespace ArturDoruch\ProcessUtil;

/**
 * Handles sending the signals (SIGTERM, SIGINT, SIGQUIT, SIGHUP) killing the process.
 *
 * @author Artur Doruch <arturdoruch@interia.pl>
 */
class ProcessKillHandler
{
    /**
     * @var bool Whether the signal has been sent.
     */
    private $signalReceived = false;

    /**
     * @var callable[]
     */
    private $listeners = [];

    /**
     * @param callable|callable[] $listeners The killing process listener or listeners function.
     *                                       The function argument:
     *                                        - $signalNumber (int) The number of the sent signal.
     * @param bool $handleStopSignal Whether to handle the stop signal "SIGTSTP" (Ctrl + Z).
     */
    public function __construct($listeners = [], $handleStopSignal = false)
    {
        foreach ((array) $listeners as $listener) {
            $this->addListener($listener);
        }

        $handler = function ($signalNumber) {
            if (!$this->signalReceived) {
                foreach ($this->listeners as $listener) {
                    $listener($signalNumber);
                }
            }

            $this->signalReceived = true;
        };

        pcntl_signal(SIGTERM, $handler); // The process was explicitly killed by the "kill" program.
        pcntl_signal(SIGINT, $handler);  // The process was interrupted by pressing Ctrl + C
        pcntl_signal(SIGQUIT, $handler); // The process was interrupted by pressing Ctrl + \
        pcntl_signal(SIGHUP, $handler);  // Terminal has been closed or hang up.

        if ($handleStopSignal === true) {
            pcntl_signal(SIGTSTP, $handler); // The process was stopped by pressing Ctrl + Z
        }
    }

    /**
     * @param callable $listener
     */
    private function addListener(callable $listener)
    {
        $this->listeners[] = $listener;
    }

    /**
     * Checks whether the signal (one of the: SIGTERM, SIGINT, SIGQUIT, SIGHUP, SIGTSTP) has been sent.
     *
     * @return bool
     */
    public function isSignalReceived(): bool
    {
        pcntl_signal_dispatch();

        return $this->signalReceived;
    }
}

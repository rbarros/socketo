<?php
namespace Ratchet\Website\Chat;
use Ratchet\ConnectionInterface;

class ConnectionStub implements ConnectionInterface {
    protected $onSend;
    protected $onClose;

    public function __construct(\Closure $onSend = null, \Cosure $onClose = null) {
        $this->setSendCallback($onSend);
        $this->setCloseCallback($onClose);
    }

    public function setSendCallback(\Closure $onSend = null) {
        $this->onSend = $onSend;
    }

    public function setCloseCallback(\Closure $onClose = null) {
        $this->onClose = $onClose;
    }

    public function send($msg) {
        if (null !== $this->onSend) {
            $cb = $this->onSend;
            $cb($msg);
        }
    }

    public function close() {
        if (null !== $this->onClose) {
            $cb = $this->onClose;
            $cb();
        }
    }
}

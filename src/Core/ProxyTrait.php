<?php
declare(strict_types=1);
namespace Crud\Core;

use Crud\Event\Subject;

trait ProxyTrait
{
    protected $_entity;

    /**
     * Proxy method for `$this->_crud()->action()`
     *
     * Primarily here to ease unit testing
     *
     * @param string|null $name Action name
     * @return \Crud\Action\BaseAction
     * @codeCoverageIgnore
     */
    protected function _action($name = null)
    {
        return $this->_crud()->action($name);
    }

    /**
     * Proxy method for `$this->_crud()->trigger()`
     *
     * Primarily here to ease unit testing
     *
     * @param string $eventName Event name
     * @param \Crud\Event\Subject|null $data Event data
     * @return \Cake\Event\EventInterface
     * @throws \Exception
     * @codeCoverageIgnore
     */
    protected function _trigger($eventName, ?Subject $data = null)
    {
        return $this->_crud()->trigger($eventName, $data);
    }

    /**
     * Proxy method for `$this->_crud()->listener()`
     *
     * Primarily here to ease unit testing
     *
     * @param string $name Listener name
     * @return \Crud\Listener\BaseListener
     * @throws \Crud\Error\Exception\ListenerNotConfiguredException
     * @throws \Crud\Error\Exception\MissingListenerException
     * @codeCoverageIgnore
     */
    protected function _listener($name)
    {
        return $this->_crud()->listener($name);
    }

    /**
     * Proxy method to get session instance.
     *
     * Primarily here to ease unit testing
     *
     * @return \Cake\Http\Session
     * @codeCoverageIgnore
     */
    protected function _session()
    {
        return $this->_request()->getSession();
    }

    /**
     * Proxy method for `$this->_container->_controller`
     *
     * Primarily here to ease unit testing
     *
     * @return \Cake\Controller\Controller
     * @codeCoverageIgnore
     */
    protected function _controller()
    {
        return $this->_controller;
    }

    /**
     * Proxy method for `$this->_container->_request`
     *
     * Primarily here to ease unit testing
     *
     * @return \Cake\Http\ServerRequest
     * @codeCoverageIgnore
     */
    protected function _request()
    {
        return $this->_controller()->getRequest();
    }

    /**
     * Proxy method for `$this->_controller()->getResponse()`
     *
     * Primarily here to ease unit testing
     *
     * @return \Cake\Http\Response
     * @codeCoverageIgnore
     */
    protected function _response()
    {
        return $this->_controller()->getResponse();
    }

    /**
     * Get a table instance
     *
     * @return \Cake\Datasource\RepositoryInterface
     */
    protected function _table()
    {
        return $this->_controller()
            ->loadModel(
                null,
                $this->getConfig('modelFactory') ?: $this->_controller()->getModelType()
            );
    }

    /**
     * Get a fresh entity instance from the primary Table
     *
     * @param array $data Data array
     * @param array $options A list of options for the object hydration.
     * @return \Cake\ORM\EntityInterface
     */
    protected function _entity(array $data = [], array $options = [])
    {
        if ($this->_entity && empty($data)) {
            return $this->_entity;
        }

        return $this->_table()->newEntity($data, $options);
    }

    /**
     * Proxy method for `$this->_crud()->getSubject()`
     *
     * @param array $additional Array of subject properties to set
     * @return \Crud\Event\Subject
     */
    protected function _subject($additional = [])
    {
        return new Subject($additional);
    }

    /**
     * Proxy method for `$this->_container->_crud`
     *
     * @return \Crud\Controller\Component\CrudComponent
     */
    protected function _crud()
    {
        if (!$this->_controller->Crud) {
            return $this->_controller->components()->load('Crud.Crud');
        }

        return $this->_controller->Crud;
    }
}

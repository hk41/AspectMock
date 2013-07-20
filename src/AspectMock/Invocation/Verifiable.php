<?php


namespace AspectMock\Invocation;


interface Verifiable {

    /**
     * Verifies a method was invoked at least once.
     * In second argument you can specify with which params method expected to be invoked;
     *
     * ``` php
     * <?php
     * $user->verifyInvoked('save');
     * $user->verifyInvoked('setName',['davert']);
     *
     * ?>
     * ```
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    public function verifyInvoked($name, $params = array());

    /**
     * Verifies that method was invoked only once.
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    public function verifyInvokedOnce($name, $params = null);

    /**
     * Verifies that method was called exactly $times times.
     *
     * ``` php
     * <?php
     * $user->verifyInvokedMultipleTimes('save',2);
     * $user->verifyInvokedMultipleTimes('dispatchEvent',3,['before_validate']);
     * $user->verifyInvokedMultipleTimes('dispatchEvent',4,['after_save']);
     *
     * ?>
     * ```
     *
     * @param $name
     * @param $times
     * @param array $params
     * @return mixed
     */
    public function verifyInvokedMultipleTimes($name, $times, $params = null);

    /**
     * Verifies that method was not called.
     * In second argument with which arguments is not expected to be called.
     *
     * ``` php
     * <?php
     * $user->setName('davert');
     * $user->verifyNeverInvoked('setName'); // fail
     * $user->verifyNeverInvoked('setName',['davert']); // success
     * ?>
     * ```
     *
     * @param $name
     * @param array $params
     * @return mixed
     */
    public function verifyNeverInvoked($name, $params = null);

}
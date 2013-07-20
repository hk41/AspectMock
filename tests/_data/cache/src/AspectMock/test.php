<?php
namespace AspectMock;

/**
 * @api
 * Class test
 * @package AspectMock
 */
class test {

    /**
     * test::double registers class or object for to track its calls.
     * In second argument you may pass return values of its methods to redefine them.
     * Returns an object with call verification methods.
     *
     * Example:
     *
     * ``` php
     * <?php
     *
     * # simple
     * $user = test::double(new User, ['getName' => 'davert']);
     * $user->getName() // => davert
     * $user->verifyInvoked('getName'); // => success
     *
     * # with closure
     * $user = test::double(new User, ['getName' => function() { return $this->login; }]);
     * $user->login = 'davert';
     * $user->getName(); // => davert
     *
     * # on class
     * $ar = test::double('ActiveRecord', ['save' => null]);
     * $user = new User;
     * $user->name = 'davert';
     * $user->save(); // passes to ActiveRecord->save() and does not insert any SQL.
     * $ar->verifyInvoked('save'); // true
     *
     * # on static method call
     *
     * User::tableName(); // 'users'
     * $user = test::double('User', ['tableName' => 'fake_users']);
     * User::tableName(); // 'fake_users'
     * $user->verifyInvoked('tableName'); // success
     *
     * ?>
     * ```
     *
     * @param $classOrObject
     * @param array $params
     * @return Core\ClassProxy|object
     */
    public static function double($classOrObject, $params = array())
    {
        if (is_object($classOrObject)) {
            Core\Registry::registerObject($classOrObject, $params);
            return $classOrObject;
        } elseif (is_string($classOrObject)) {
            Core\Registry::registerClass($classOrObject, $params);
            return new Core\ClassProxy($classOrObject);
        }
    }

    public static function dummy($className, $params = array())
    {
        $reflectionClass = new \ReflectionClass($className);
        $instance = $reflectionClass->newInstanceWithoutConstructor();
        return self::double($instance, $params);
    }

    public static function fake($className)
    {
        return self::fakeExcept($className, []);
    }

    public static function fakeExcept($className, array $exceptParams)
    {
        $reflectionClass = new \ReflectionClass($className);
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);
        $instance = $reflectionClass->newInstanceWithoutConstructor();
        $params = array();
        foreach ($methods as $m) {
            if (in_array($m->name, $exceptParams)) continue;
            $params[$m->name] = null;
        }
        return self::double($instance, $params);
    }

    public static function clean()
    {
        Core\Registry::clean();
    }


}
<?php
/**
 * 第三方登陆验证
 * 
 * @category MobilePf2
 * @package Qihu
 * @namespace Qihu
 * @copyright Copyright (c) 2004 - $Year$ Zfirm Inc.
 * @author $Author: zhangweiwen $
 * @version $Id: Module.php 40625 2014-01-29 03:41:55Z zhangweiwen $
 */

namespace Qihu;

use Zend\Mvc\ModuleRouteListener;
use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\ModuleManager\Feature\BootstrapListenerInterface;
use Zend\ModuleManager\Feature\ServiceProviderInterface;
use Zend\EventManager\EventInterface;

/**
 * 奇虎(360)模块的管理类
 * 
 * @name Module
 */
class Module implements AutoloaderProviderInterface, ConfigProviderInterface, 
                        BootstrapListenerInterface, ServiceProviderInterface
{
    /**
     * 
     * @see \Zend\ModuleManager\Feature\AutoloaderProviderInterface::getAutoloaderConfig()
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
		    // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }

    /**
     * 
     * @see \Zend\ModuleManager\Feature\ConfigProviderInterface
     */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @see \Zend\ModuleManager\Feature\BootstrapListenerInterface::onBootstrap()
     */
    public function onBootstrap(EventInterface $e)
    {
        // You may not need to do this if you're doing it elsewhere in your
        // application
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }
    
    /**
     * 
     * @see \Zend\ModuleManager\Feature\ServiceProviderInterface::getServiceConfig()
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Qihu\Auth\Http' => 'Qihu\Service\AuthHttpFactory'
            ), 
        );
    }
}

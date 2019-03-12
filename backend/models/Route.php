<?php
/**
 * Created by PhpStorm.
 * User: ahanfeng
 * Date: 18-11-26
 * Time: 下午2:07
 */

namespace backend\models;


use common\base\BaseActive;
use common\core\component\AdminConfigsComponent;
use common\core\helper\AuthHelper;
use yii\helpers\VarDumper;
use Yii;
use yii\caching\TagDependency;


class Route extends BaseActive
{

    const CACHE_TAG = 'fn_admin_route';
    const ROUTE_NAME_DOC_MATH='/@routeName.*/';
    const ROUTE_DESC_DOC_MATH='/@routeDescription.*/';

    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    public function rules()
    {
      return[
          ['name','required','message'=>"路由地址不能为空"],
      ];


    }

    /**
     * Assign or remove items
     * @param array $routes
     * @throws
     */
    public function addNew($routes)
    {
        $manager = Yii::$app->getAuthManager();
        $appRoutes=$this->getAvaliableRoutes();
        foreach ($routes as $key=>$val) {
            if (!isset($val['route'])){
                continue;
            }
            $route=$val['route'];
            try {
                $r = explode('&', $route);
                $item = $manager->createPermission('/' . trim($route, '/'));
                if (isset($appRoutes[$route])){
                    $itemRoute=$appRoutes[$route];
                    $item->data=$val['data']??[];
                    $item->data['route_name']=$itemRoute['route_name']??"";
                    $item->data['route_description']=$itemRoute['route_description']??"";
                }else{
                    $item->data=$val['data'];
                }

                if (count($r) > 1) {
                    $action = '/' . trim($r[0], '/');
                    if (($itemAction = $manager->getPermission($action)) === null) {
                        $itemAction = $manager->createPermission($action);
                        $manager->add($itemAction);
                    }
                    unset($r[0]);
                    foreach ($r as $part) {
                        $part = explode('=', $part);
                        $item->data['params'][$part[0]] = isset($part[1]) ? $part[1] : '';
                    }
                    $this->setDefaultRule();
                    $item->ruleName = RouteRule::RULE_NAME;
                    $manager->add($item);
                    $manager->addChild($item, $itemAction);
                } else {
                    $manager->add($item);
                }
            } catch (\Exception $exc) {

                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
        AuthHelper::invalidate();
    }

    /**
     * Assign or remove items
     * @param array $routes
     * @return array
     */
    public function remove($routes)
    {
        $manager = Yii::$app->getAuthManager();
        foreach ($routes as $route) {
            try {
                $item = $manager->createPermission('/' . trim($route, '/'));
                $manager->remove($item);
            } catch (\Exception $exc) {
                Yii::error($exc->getMessage(), __METHOD__);
            }
        }
       AuthHelper::invalidate();
    }

    /**
     * Get 获取有的可用路由列表
     * @return array
     */
    public function getAvaliableRoutes()
    {

        $routes = $this->getAppRoutes();

        return $routes;
    }

    /**
     * 获取添加到数据库的列表
     * @return \yii\rbac\Permission[]
     */

    public function getAssignedRoutes()
    {

        $r=Yii::$app->getAuthManager()->getPermissions();
        $route=[];
        foreach ($r as $key=>$value){
            if ($key[0] !== '/') {
                continue;
            }
            $route[$key]=$value;
        }
        return $route;
    }

    /**
     * Get list of application routes
     * @throws
     * @return array
     */
    public function getAppRoutes($module = null)
    {
        if ($module === null) {
            $module = Yii::$app;
        } elseif (is_string($module)) {
            $module = Yii::$app->getModule($module);
        }
        $key = [__METHOD__, $module->getUniqueId()];
        $cache = AdminConfigsComponent::instance()->cache;

        if ($cache === null || ($result = $cache->get($key)) === false) {
            $result = [];
            $this->getRouteRecrusive($module, $result);
            if ($cache !== null) {
                $cache->set($key, $result, AdminConfigsComponent::instance()->cacheDuration, new TagDependency([
                    'tags' => AdminConfigsComponent::CACHE_TAG,
                ]));
            }
        }

        return $result;
    }

    /**
     * Get route(s) recrusive
     * @param \yii\base\Module $module
     * @param array $result
     */
    protected function getRouteRecrusive($module, &$result)
    {
        $token = "Get Route of '" . get_class($module) . "' with id '" . $module->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            foreach ($module->getModules() as $id => $child) {
                if (($child = $module->getModule($id)) !== null) {
                    $this->getRouteRecrusive($child, $result);
                }
            }

            foreach ($module->controllerMap as $id => $type) {
                $this->getControllerActions($type, $id, $module, $result);
            }

            $namespace = trim($module->controllerNamespace, '\\') . '\\';
            $this->getControllerFiles($module, $namespace, '', $result);

            $all = '/' . ltrim($module->uniqueId . '/*', '/');
            $result[$all] =['route'=>$all];
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list controller under module
     * @param \yii\base\Module $module
     * @param string $namespace
     * @param string $prefix
     * @param mixed $result
     * @return mixed
     */
    protected function getControllerFiles($module, $namespace, $prefix, &$result)
    {
        $path = Yii::getAlias('@' . str_replace('\\', '/', $namespace), false);
        $token = "Get controllers from '$path'";
        Yii::beginProfile($token, __METHOD__);
        try {
            if (!is_dir($path)) {
                return;
            }
            foreach (scandir($path) as $file) {
                if ($file == '.' || $file == '..') {
                    continue;
                }
                if (is_dir($path . '/' . $file) && preg_match('%^[a-z0-9_/]+$%i', $file . '/')) {
                    $this->getControllerFiles($module, $namespace . $file . '\\', $prefix . $file . '/', $result);
                } elseif (strcmp(substr($file, -14), 'Controller.php') === 0) {
                    $baseName = substr(basename($file), 0, -14);
                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', $baseName));
                    $id = ltrim(str_replace(' ', '-', $name), '-');
                    $className = $namespace . $baseName . 'Controller';
                    if (strpos($className, '-') === false && class_exists($className) && is_subclass_of($className, 'yii\base\Controller')) {
                        $this->getControllerActions($className, $prefix . $id, $module, $result);
                    }
                }
            }
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get list action of controller
     * @param mixed $type
     * @param string $id
     * @param \yii\base\Module $module
     * @param string $result
     */
    protected function getControllerActions($type, $id, $module, &$result)
    {
        $token = "Create controller with cofig=" . VarDumper::dumpAsString($type) . " and id='$id'";
        Yii::beginProfile($token, __METHOD__);
        try {
            /* @var $controller \yii\base\Controller */
            $controller = Yii::createObject($type, [$id, $module]);
            $this->getActionRoutes($controller, $result);
            $all = "/{$controller->uniqueId}/*";
            $result[$all] = ['route'=>$all];
        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * Get route of action
     * @param \yii\base\Controller $controller
     * @param array $result all controller action.
     */
    protected function getActionRoutes($controller, &$result)
    {
        $token = "Get actions of controller '" . $controller->uniqueId . "'";
        Yii::beginProfile($token, __METHOD__);
        try {
            $route_name=$route_description="";
            $prefix = '/' . $controller->uniqueId . '/';
            $class = new \ReflectionClass($controller);

            foreach ($class->getMethods() as $method) {
                $name = $method->getName();


                if ($method->isPublic() && !$method->isStatic() && strpos($name, 'action') === 0 && $name !== 'actions') {
                    $doc_comment= $method->getDocComment();

                    $name = strtolower(preg_replace('/(?<![A-Z])[A-Z]/', ' \0', substr($name, 6)));
                    $id = $prefix . ltrim(str_replace(' ', '-', $name), '-');
                     preg_match(self::ROUTE_NAME_DOC_MATH, $doc_comment, $name_matches);
                     preg_match(self::ROUTE_DESC_DOC_MATH, $doc_comment, $desc_matches);
                    if (isset($name_matches[0])){
                        $route_name=explode(" ",$name_matches[0])[1];
                    }if (isset($desc_matches[0])){
                        $route_description=explode(" ",$desc_matches[0])[1];
                    }

                }
                if (!empty($id)){
                    $result[$id]=['route'=>$id,'route_name'=>$route_name,'route_description'=>$route_description];
                    $results[$id]=['route'=>$id,'route_name'=>$route_name,'route_description'=>$route_description];
                }
            }

        } catch (\Exception $exc) {
            Yii::error($exc->getMessage(), __METHOD__);
        }
        Yii::endProfile($token, __METHOD__);
    }

    /**
     * @throws \Exception
     */
    protected function setDefaultRule()
    {
        if (Yii::$app->getAuthManager()->getRule(RouteRule::RULE_NAME) === null) {
            Yii::$app->getAuthManager()->add(new RouteRule());
        }
    }
}
<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Samils\ApplicationServerHelpers
 * - Autoload, application dependencies
 *
 * MIT License
 *
 * Copyright (c) 2020 Ysare
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */
namespace Sammy\Packs\Samils\ApplicationServerHelpers {
  use FileSystem\Folder as Dir;
  use Configure as Conf;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists('Sammy\Packs\Samils\ApplicationServerHelpers\Base')){
  /**
   * @trait Base
   * Base internal trait for the
   * Samils\ApplicationServerHelpers module.
   * -
   * This is (in the ils environment)
   * an instance of the php module,
   * wich should contain the module
   * core functionalities that should
   * be extended.
   * -
   * For extending the module, just create
   * an 'exts' directory in the module directory
   * and boot it by using the ils directory boot.
   * -
   */
  trait Base {
    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function RootDir () {
      static $rootDir = null;

      $alternate_consts = array (
        'approot', '__root__',
        'BASEDIR'
      );

      if (!is_null ($rootDir)) {
        return $rootDir;
      }

      foreach ($alternate_consts as $alternate) {
        if (defined ($alternate)) {
          $rootDir = constant ($alternate);
          break;
        }
      }

      return $rootDir;
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function PublicDir () {
      $const = 'Configure::ApplicationPublicFolder';
      return defined($const) ? constant($const) : (
        join (DIRECTORY_SEPARATOR, [
          Conf::ApplicationRoot, 'public'
        ])
      );
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function AssetsDir () {
      $ds = DIRECTORY_SEPARATOR;
      $definedAssetsDirConst = ( boolean )(
        class_exists ('Configure') &&
        defined ('Configure::ApplicationRoot')
      );

      if ($definedAssetsDirConst) {
        return join (DIRECTORY_SEPARATOR, [
          Conf::ApplicationRoot, 'app', 'assets'
        ]);
      }
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function AssetsPath () {
      $definedAssetsDirConst = ( boolean )(
        class_exists ('Configure') &&
        defined ('Configure::ApplicationAssetsPath')
      );

      if ( $definedAssetsDirConst ) {
        return constant ('Configure::ApplicationAssetsPath');
      }
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function ConfigDir () {
      $const = '__config__';
      $ds = DIRECTORY_SEPARATOR;
      $configConst = 'Configure::ApplicationRoot';
      return (defined($const) ? constant($const) : (
        class_exists ('Configure') &&
        !defined ($configConst) ? null : join ($ds, [
          Conf::ApplicationRoot, 'config'
        ])
      ));
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function DatabaseConfigFile () {
      return join (DIRECTORY_SEPARATOR, [
        self::ConfigDir (), 'database.yaml'
      ]);
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function Env () {
      return ($env = ENV::Get ('ILS_ENV')) ? $env : 'production';
    }

    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    protected static function configureServerFluxState () {
      /**
       * [$application_server Application Server Instance]
       * @var Samils\Application\Server\Base
       */
      $applicationServer = requires ('application-server');
      /**
       * @method configureServerFluxState
       * - Configure the application server base
       * - in order preparating the application
       * - slices and make it ready for running the
       * - app correctly
       */
      $applicationServer->configureServerFluxState (
        new Dir ( self::ConfigDir () )
      );
    }
    /**
     * @version 1.0
     *
     * THE CURRENT ILS COMMAND IS PROVIDED
     * TO AID THE DEVELOPMENT PROCESS IN ORDER
     * IT GET IN THE SAME WAY WHEN MOVING IT FROM
     * ANOTHER TO ANOTHER ENVIRONMENT.
     *
     * Note: on condition that this is an automatically
     * generated file, it should not be directly changed
     * without saving whole the changes into the original
     * repository source.
     *
     * @author Ag
     * @keywords Function Keywords
     */
    public static function conf ($config = null) {
      static $serverConfigData = [];

      if (is_string ($config)) {
        $defaultConfigPropValue = func_num_args () > 1 ? func_get_arg (1) : null;
        $config = strtolower ($config);
        return !isset ($serverConfigData [$config]) ? $defaultConfigPropValue : $serverConfigData [strtolower ($config)];
      }

      if (is_array ($config)) {
        $serverConfigData = array_merge ($serverConfigData, $config);
      }

      if (is_null ($config)) {
        return $serverConfigData;
      }
    }
  }}
}

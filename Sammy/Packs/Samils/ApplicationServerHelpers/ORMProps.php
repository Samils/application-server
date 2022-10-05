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
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists('Sammy\Packs\Samils\ApplicationServerHelpers\ORMProps')){
  /**
   * @trait ORMProps
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
  trait ORMProps {
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
    public static function GetOrmProps ($initialProps = []) {
      if (!is_array ($initialProps)) {
        $initialProps = [];
      }

      $yamlLite = requires ('yaml-lite');

      $databaseConfig = $yamlLite->parse_yaml_file (self::DatabaseConfigFile ());

      $envDBConfig = self::GetEnvsDatabaseConfig ($databaseConfig);
      $currentEnvDBConfig = [];

      if (isset ($envDBConfig [self::Env ()])) {
        $currentEnvDBConfig = $envDBConfig [self::Env ()];
      }

      return array_merge ($initialProps, [
        'database' => $currentEnvDBConfig,
        'props' => $envDBConfig [ '@props' ]
      ]);
    }


    public static function GetEnvsDatabaseConfig (array $databaseConfig = []) {
      $envDBConfig = [
        'defaults' => [],
        '@props' => []
      ];

      $envs = [
        'development',
        'production',
        'test',
        'defaults'
      ];

      foreach ($databaseConfig as $property => $val) {
        $prop = self::rewritePropertyName ($property);

        if (in_array (strtolower ($prop), $envs)) {

          if (isset ($envDBConfig [ $prop ])) {
            $envDBConfig [ $prop ] = array_merge (
              $envDBConfig [ $prop ], $val
            );
          } else {
            $envDBConfig [ $prop ] = $val;
          }

          $envDBConfig [ $prop ] = array_merge (
            $envDBConfig [ 'defaults' ],
            $envDBConfig [ $prop ]
          );
        } else {
          $envDBConfig['@props'][$prop] = $val;
        }
      }

      return $envDBConfig;
    }


    /**
     * @method string rewritePropertyName
     *
     * Rewrite property name...
     *
     */
    private static function rewritePropertyName ($prop) {
      if (preg_match('/^(def(ault(s|)|))$/i', $prop))
        return 'defaults';
      if (preg_match('/^(dev(elopment|))$/i', $prop))
        return 'development';
      if (preg_match('/^(prod(uction|))$/i', $prop))
        return 'production';
      if (preg_match('/^(test)$/i', $prop))
        return 'test';
      return $prop;
    }


  }}
}

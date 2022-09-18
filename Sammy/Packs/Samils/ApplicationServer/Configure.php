<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Samils\ApplicationServer
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
namespace Sammy\Packs\Samils\ApplicationServer {
  use Configure as Conf;
  use php\module as phpmodule;
  use FileSystem\Folder as Dir;
  use Samils\Handler\HandleOutPut;
  use Sammy\Packs\Samils\ApplicationServerHelpers;
  /**
   * Make sure the module base internal trait is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!trait_exists ('Sammy\Packs\Samils\ApplicationServer\Configure')) {
  /**
   * @trait Configure
   * Base internal trait for the
   *\Samils\ApplicationServer module.
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
  trait Configure {
    use Configure\Path;

    /**
     * @method config
     * - Configure the application server file based
     * - on the 'application-server' file inside the
     * - application configuration file
     * ----------------------------------------------
     * - Extension for 'application-server' file:
     * -- yaml
     * -- json
     * -- php
     */
    public function configureServerFluxState (Dir $confDir) {
      $confDatas = $this->getConfigureFileDatas ( $confDir );

      ApplicationServerHelpers::conf ($confDatas);

      if (!is_array ($confDatas)) {
        return NoConfigFileError::Handle (debug_backtrace ());
      }

      self::ConfigureApplicationPaths ($confDatas);
      self::configureApplicationFlux ();

      ApplicationServerHelpers::conf ([
        'view-engine' => self::configureApplicationViewEngine ()
      ]);
    }

    /**
     * @method getConfigureFileDatas
     * - Get Application Server Configure File Datas
     * - Acording to the type of the configure file
     * - Try getting the content as an array
     */
    private function getConfigureFileDatas (Dir $dir) {
      # FileName: The application
      # server config file name
      $f = 'application-server';

      $alts = ['.php', '.yaml', '.yml', '.json'];

      $file = null;
      $ext = null;

      foreach ( $alts as $i => $alt ) {
        if ($dir->containsFile ($f . $alt)) {
          $file = $dir->abs ($f . $alt);
          $ext = $alt;
          break;
        }
      }

      if ($ext === '.json') {
        return json_decode (file_get_contents ($file));
      } elseif ($ext === '.php') {
        return requires ($file);
      } elseif (in_array ($ext, ['.yaml', '.yml'])) {
        $yaml = requires ('yaml-lite');

        if (is_object ($yaml)) {
          return $yaml->parse_yaml_file ($file);
        }
      }
    }

    public static function configureApplicationORM () {
      $confDatas = ApplicationServerHelpers::conf ();

      if (!(isset ($confDatas ['application_orm'])
        && is_string ($confDatas ['application_orm'])
      )) {
        exit ('<h1>Error, no ORM set</h1><br />');
      }

      if (!isset($confDatas ['application_orm_config'])) {
        $confDatas['application_orm_config'] = [
          'migrations_location' => 'db/migrations'
        ];
      }

      $ormProps = ApplicationServerHelpers::GetOrmProps (
        ['config' => $confDatas ['application_orm_config']]
      );


      $Orm = requires ($confDatas ['application_orm']);

      $orm = $Orm ($ormProps);

      if (is_object ($orm)) {
        $orm->BaseConfig ();
      } else {
        exit ('BAD, ORM NOT SET');
      }
    }

    public static function configureApplicationViewEngine () {
      $confDatas = ApplicationServerHelpers::conf ();

      $viewEngineManager = isset ($confDatas ['view engine manager']) ? (
        $confDatas['view engine manager']
      ) : '\\php\\view';

      $viewEngineScripts = isset($confDatas['view engine scripts']) ? (
        $confDatas['view engine scripts']
      ) : [];

      $vem = requires ( $viewEngineManager );

      if (method_exists ($vem, 'start')) {
        return $vem->start (
          isset ($confDatas ['view engine datas']) ? (
            $confDatas ['view engine datas']
          ) : []
        );
      } else {
        return error_noStartFileInVem ();
      }
    }

    public static function configureApplicationFlux () {
      $confDatas = ApplicationServerHelpers::conf ();

      #echo '<pre>';
      #print_r($confDatas);
      #exit ('');

      $applicationFluxSet = ( boolean ) (
        isset ($confDatas['application_flux']) && (
          is_string ($confDatas['application_flux']) ||
          is_array ($confDatas['application_flux'])
        )
      );

      if ( !$applicationFluxSet ) {
        exit ('Error, No application_flux');
      } else {
        /**
         * Deine the appFlux Value to get the
         * current application's
         */
        if (is_array ($confDatas ['application_flux'])) {
          $appFlux = $confDatas ['application_flux'];
        } else {
          $appFlux = preg_split ('/\s*/',
            $confDatas ['application_flux']
          );
        }

        $flux = array ();

        foreach ( $appFlux as $f ) {
          if ( empty ($f) )
              continue;

          if (in_array (strtolower ($f), ['m', 'v', 'c'])) {
            /**
             * Avoid repeating
             */
            if (!in_array (strtoupper ($f), $flux)) {
              array_push ($flux, strtoupper ($f) );
            }
          } else {
            exit ('Unknown ' .$f .' in MVC');
          }
        }

        ApplicationServerHelpers::conf (['flux' => $flux]);
      }
    }
  }}
}

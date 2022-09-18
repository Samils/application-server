<?php
/**
 * @version 2.0
 * @author Sammy
 *
 * @keywords Samils, ils, php framework
 * -----------------
 * @package Sammy\Packs\Sami\LiveConfigure
 * - Autoload, application dependencies
 * -
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
 * -
 * The current file is a container for the
 * application configuration base class;
 * wish contains the basis for the main
 * application configurations and features
 * specifications.
 * -
 * A way for getting informations contained inside
 * the '.config.php' file in the project root directory
 * directory from the 'ConfigureBase' class created
 * in the current file as a parent for the 'Configure'
 * class that extends it from the main live configure
 * file.
 * -
 * @file confbsc
 * - Configure base Class
 *
 * THIS IS THE ILS CONFIGURE BASE
 * CLASS, CREATED BY THE LIVE CONFIGURE
 * FOR THE ILS APP.
 *
 * @live-configure version: 0.1.2
 * @created at: 16/05/2020
 *
 */
namespace Sammy\Packs\Samils\ApplicationServer\LiveConfigure {
  use Sammy\Packs\Samils\ApplicationServerHelpers as Helper;
  use Samils\Handler\HandleOutPut;
  use php\module as phpmodule;
  /**
   * Make sure the module base internal class is not
   * declared in the php global scope defore creating
   * it.
   * It ensures that the script flux is not interrupted
   * when trying to run the current command by the cli
   * API.
   */
  if (!class_exists('Samils\Application\Server\LiveConfigure\Supper')){
  /**
   * @class Supper
   * Base internal class for the
   * ModuleName module.
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
  class Supper {
    private static $built = false;

    /**
     * @method void Build
     */
    public static function Build () {
      if (self::$built) return;

      self::$built = true;

      $config_file_path = join (DIRECTORY_SEPARATOR,
        [Helper::RootDir (), '.config.php']
      );

      # configures
      # This'll be an instance of the '.config' module
      # in the project root directory wich'll contain
      # whole the initial configurations variables
      # contained inside the '.config.php' file in
      # the project root directory.
      # Used to setup some the application configurations
      # and getting strated the application system.
      $configures = ConfigureGetter::GetConfigures (
        # config_file_path
        # The absolute path to the
        # configuration file inside the
        # project root directory, wich
        # contain whole the initial configurations
        # variables for setting the current ils
        # application up
        dirname ($config_file_path)
      );

      if (is_array ($configures) && isset ($configures['modules'])) {
        phpmodule::config ( $configures['modules'] );
      }

      # [$cl_init_code description]
      # Class Initial Code
      # Initial code for the 'ConfigureBase' class
      # @var string
      $cl_init_code = 'namespace Sammy\Packs\Samils\ApplicationServer\LiveConfigure\Supper; class Base {';
      # conf_base_map
      # Configurations base map
      # A map of whole the applications
      # base configurations contained in the
      # $configures array.
      $conf_base_map = 'protected static $BaseMap = [';
      # Map the '$configures' array to use
      # ecah key and value inside it to
      # create a constant inside it that'll
      # provide a reference for the defined
      # property and wich value would be the
      # same than the property in the '$configure'
      # array in the '.config' module.
      foreach ($configures as $key => $val) {
        # [$k description]
        # @var [type]
        #
        # Rewrite and sanitize the property
        # name in order making it usable as
        # a constant name in the ConfigureBase
        # class and avoid having errors when
        # trying to use an incorrect variable
        # name as a constant.
        #
        # Replacing supported chars (by live configure)
        # such as space and - by empty or _ (underscore).
        $k = preg_replace('/\s+/', '',
          # Before replacing spaces, it'll
          # have to replace whole - chars
          # by underscore chars in order
          # having a right var name when
          # using this properties as constant
          # name inside the 'ConfigureBase'
          # class created bellow.
          preg_replace('/-+/', '_',
            # The current (in the loop)
            # property name that'll be
            # used as a consant name in the
            # 'ConfigureBase' class.
            $key
          )
        );
        # Skip the current property name if it
        # is not a right var name and should not
        # be used as a constant name.
        # It is a way of avoiding to have errors
        # when drawing the ConfigureBase class inside
        # live configure.
        #
        # DO NOT EDIT THE LINE BELLOW UNLESS YOU ARE
        # SURE ABOUT WHAT YOU ARE DOING AND THE RESULTS
        # IT SHOULD BRING TO YOU APPLICATION FUNCTIONALITY.
        # EDITING THIS FILE SHOULD BE A WAY FOR HAVING A
        # DIFFERENT BEHAVIOR IN THE APPLICATION LIVE CONFIGURE
        # AND IT SHOULD (WILL) CHANGE ABSOLUTELY THE APPLICATION
        # FLUX; ON CONDITION THAT WHOLE OF THE REST PART OF ILS
        # DEPENDS ON LIVE CONFIGURE BASE CLASS TO RUN CORRECTLY.
        #
        # - Now, Skip and look for the next property name
        #   in the '$configures' array in order trying to
        #   use that to draw the ConfigureBase class.
        if (!preg_match ('/^([a-zA-Z_]([a-zA-Z0-9_]*))$/', $k)) {
          # On condition that the current property
          # name is not a right variable name
          # according to the php pattern,
          # it'll stop the current iteration and
          # go to the next.
          continue;
        }

        # At the current time, live-confire'll
        # treat the current property value in order
        # having it as is declared in the '$configure'
        # array, according to the value type it will
        # attribute a different value for the constant in
        # the ConfigureBase class.
        # ---
        # Keep the current value as it is if
        # the value type is a boolean or a numeric
        # value.
        if (is_bool($val) || is_numeric($val)) {
          # Set the '$val' value as it is
          # inside the '$v' variable in case
          # of being a boolean value or a numeric
          # value (int or float).
          # On condition that a constant supports
          # that values, they should be usable like
          # they are inside the ConfigureBase class
          # declared late.
          $v = $val;
        } elseif (is_string($val)) {
          # Assuming that '$val' is a string,
          # store that between quotes in order
          # creating a string that should be
          # the value for the current property
          # when declared the constant in the
          # class.
          # Before idoing that, scape whole the
          # ' chars in order avoiding to have more
          # inside the generated string and having
          # bugs when drawing the final ConfigureBase
          # class.
          $v = ('\'' . preg_replace('/\\\'/', '\'', $val)
            . '\''
          );
        } elseif (is_array($val)) {
          # Assuming that '$val' is an array,
          # stringify it width the 'array_stringify'
          # function in order drawing a new array
          # based on the given array and discard
          # whole the variable  types no supported
          # by php constants and should not be usable
          # inside the ConfigureBase class.
          # ---
          # Recreate the '$val' array in order
          # filtering the values on it and rewrite
          # them.
          $v = HandleOutPut::array_stringify (
            # The current value in the '$configures'
            # array based on the iterator.
            # ---
            # Redrawing the array structure to replace
            # unsopprted vars by string or any other type
            # that should be supported by php constants.
            $val
          );
          # '$v' now should have a sstructure as seen,
          # based on the basic php array syntax.
          # [ 'modules' => ['paths' => ['@root' => 'Root Path']] ]
        } else {
          # Assuming that '$val' has an unkown
          # type according to the supported list
          # specification, it should be converted
          # to a string in order avoiding to have
          # bugs when trying to evaluate a constant
          # with an unsupported value according to
          # the php specifications.
          $v = json_encode($val);
        }

        $cl_init_code .= ("const $k = $v;\n");
        $conf_base_map .= ('\''.$k . '\' => ' . $v . ',');
      }
      $cl_init_code .= ''.$conf_base_map.'];}';

      # Run The generated class body
      # and create a 'ConfigureBase'
      # class
      #echo $cl_init_code, "\n\n\n\n";
      eval($cl_init_code);
    }
  }}
}

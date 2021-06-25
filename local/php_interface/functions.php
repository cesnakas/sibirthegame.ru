<?
// Функция для сортировки массива
function sortValuesFilterName($a, $b){
    if ($a['name'] == $b['name']) {
        return 0;
    }
    return ($a['name'] < $b['name']) ? -1 : 1;
}

/**
 * Функции для отладки кода
 *
 * @author ivanko
 * @package tools
 *         
 */

if (! function_exists("prn_")) {

    /**
     * Записывает/перезаписывает переданный объект в файл dump.html, обработав функцией print_r
     *
     * @param mixed $obj
     *            Объект, который необходимо записать в файл
     * @param bool $rewrite
     *            Указывает на перезапись отладочного файла
     * @param bool $bAll
     *            Указывает на разрешение записи в файл для любого пользователя, по умолчанию false
     *            
     * @example <pre>
     *          prn_($obj, $rewrite, $bAll = false)
     *          </pre>
     *         
     */
    function prn_($obj, $rewrite, $bAll = false)
    {
        if (! debug() && ! $bAll)
            return;

        $dump = "<pre style='font-size: 11px; font-family: tahoma;'>" . print_r($obj, true) . "</pre>";
        $file = $_SERVER["DOCUMENT_ROOT"] . "/dump.html";

        $fp = fopen($file, ($rewrite ? "w+" : "a+")) or die("Не могу открыть $temp");
        fwrite($fp, $dump);
        @fclose($fp);
    }
}

if (! function_exists("debug")) {

    /**
     * Проверяет на возможность вывода отладочной информации
     *
     * @return bool
     *
     * @example <pre>
     *          if(debug()) {
     *          \/* Ваш код *\/
     *          }
     *          </pre>
     *         
     */
    function debug()
    {
        global $USER;
        if ($USER === null)
            $USER = new CUser();
        
        if (isset($_REQUEST["set_debug"]))
            $_SESSION["DEBUG"] = "Y";
        if (isset($_REQUEST["unset_debug"]))
            $_SESSION["DEBUG"] = "N";
        
        return ($_SESSION["DEBUG"] == "Y" || @$USER->IsAdmin() || (is_set($_REQUEST, "debug") && $_REQUEST["debug"] == "Y") || defined("STDIN"));
    }
}

if (! function_exists("p")) {

    /**
     * Распечатывает переданную переменую на странице c помощью print_r
     *
     * @param mixed $value
     *            Переменная, которую необходимо распечатать
     * @param bool $die
     *            Указывает на обрываение выполнения страницы после распечатывания перемнной, по умолчанию false
     * @param bool $bHtml
     *            Указывает на преобразование строки с помощью htmlspecialchars(), по умолчанию true
     *            
     * @return void
     *
     * @example <pre>
     *          p($arFields, 1)
     *          </pre>
     *         
     */
    function p($value, $die = false, $bHtml = true)
    {
        if (!debug())
            return;

        if (is_bool($value)) {
            $value = 'bool: ' . ($value == true ? 'true' : 'false');
        }

        $sReturn = print_r($value, true);

        $debug_backtrace = debug_backtrace();


        if (defined("STDIN")) /* php-cli */ {
            echo "\r\n==========\r\n" . $sReturn . "\r\n==========\r\n";
        } else {
            if ($bHtml) {
                $sReturn = htmlspecialchars($sReturn);
            }

            echo "<pre data-source=\"" . substr($debug_backtrace[1]["file"],
                    strlen($_SERVER["DOCUMENT_ROOT"])) . ":" . $debug_backtrace[1]["line"] . "\" style=\"overflow:auto; color: #000; background-color: white; border: 1px solid #CCC; padding: 5px; font-size: 12px;\">" . $sReturn . "</pre>";
        }

        if ($die) {
            if (is_a($GLOBALS["APPLICATION"], "CMain")) {
                echo $GLOBALS["APPLICATION"]->EndBufferContentMan();
            } else {
                ob_get_flush();
            }
            die();
        }
    }
}

if (! function_exists("p2f")) {

    /**
     * Записывает переданный объект в файл #USER_ID#-dump.html, обработав функцией print_r
     *
     * @param mixed $obj
     *            Объект, который необходимо записать в файл
     *            
     * @return void
     *
     * @example <pre>
     *          p2f($arFields, 1)
     *          </pre>
     *         
     */
    function p2f($obj)
    {
        global $USER;
        $id = is_object($USER) && $USER->GetID() ? $USER->GetID() : 'guest';
        $dump = "<pre style='font-size: 11px;'>" . print_r($obj, true) . "</pre>";
        $files = $_SERVER["DOCUMENT_ROOT"] . "/" . $id . "-dump.html";
        $fp = fopen($files, "a+");
        fwrite($fp, $dump);
        fclose($fp);
    }
}
<?php 

/**
 * Returns View Directory
 *
 * @return void
 */
function viewsPath()
{
    return BASE_PATH . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR;
}

/**
 * Writes data to a Log and signs date and title
 *
 * @param  mixed $data
 * @param  mixed $title
 * @return void
 */
function writeToLog($data, $title = '')
{
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r($data, 1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook.log', $log, FILE_APPEND);
    return true;
}

/**
 * Display the alert box 
 *
 * @param  mixed $message
 * @return void
 */
function function_alert($message) { 
      
    echo "<script>alert('$message');</script>"; 
} 

/**
 * Call Bitrix inbound WebHook
 *
 * @param  mixed $endpoint
 * @param  mixed $data
 * @return void
 */
function webHookCall($endpoint, $data)
{
    $hook = 'https://b24-94dhu6.bitrix24.com.br/rest/1/85fqr82wsk7680s7/';
    $queryUrl = $hook . $endpoint;
    $queryData = http_build_query($data);

    $curl = curl_init($queryUrl);
    curl_setopt_array($curl, array(
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POST => true,
        CURLOPT_HEADER => false,
        CURLOPT_RETURNTRANSFER => true,
        //CURLOPT_URL => $queryUrl,
        CURLOPT_POSTFIELDS => $queryData,
    ));

    $result = curl_exec($curl);

    curl_close($curl);

    $result = json_decode($result, 1);

    //writeToLog($queryData, 'webform');
    writeToLog($result, $endpoint);

    return $result;
}
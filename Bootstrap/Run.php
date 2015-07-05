<?php
require_once '../Classes/autoload.php';
use Command\Fetch\Command as Run;
use Twitter\Data\Options as TwitterOptions;
use Command\Set\TwitterCommand as LoadData;
use Url\Twitter\Timeline as twitterData;
use Data\Process\Json as Json;
use Data\Process\Results as Results;
use PDO\Mysql\Connect as Connect;
use Database\Get\Data as Mysql;
use Display\Output as ShowFindings;
$mysqliObj = new Connect();
$mysql = new Mysql($mysqliObj->getMysqli());
$commands = new Run();
$options = new TwitterOptions();
$twitterParms = new LoadData($commands, $options);
$twitter = new twitterData($twitterParms);
$json = new Json($twitter->fetchTimeline());
$results = new Results($mysql, $json);
$display = new ShowFindings($results);


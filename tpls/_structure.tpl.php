<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <?php $pv_page_title = empty($pv_page_title) ? 'Panel Helper' : htmlspecialchars($pv_page_title) . ' &bull; Panel Helper';?>
    <title><?php echo $pv_page_title?></title>
    <script type="text/javascript">
        var RANDOM_ORG_KEY = '5045005e-f0b1-4e80-a51d-276b90b9c4ef';
    </script>
    <link rel="icon" type="image/png" href="images/logo.png" />
    
    <link rel="stylesheet" type="text/css" media="screen" href="css/main.css?0331">
    <link rel="stylesheet" type="text/css" media="screen" href="css/colors.css?0331">
    <link rel="stylesheet" type="text/css" media="screen" href="css/draw_history.css?0331">
    <meta name="author" content="Maciej Jaros">
    <meta name="copyright" content="Maciej Jaros">

    <!-- jQuery -->
    <link type="text/css" href="./js/jquery/css/ui-lightness/jquery-ui-custom.css?0331" rel="stylesheet">
    <script type="text/javascript" src="./js/jquery/js/jquery-min.js"></script>
    <script type="text/javascript" src="./js/jquery/js/jquery-ui-custom.min.js"></script>
    
    <!-- jQuery inits and other global stuff -->
    <script type="text/javascript" src="./js/logger.js?0331"></script>
    <script type="text/javascript" src="./js/localforage.min.js?0331"></script>
    <script type="text/javascript" src="./js/prepare-std.js?2329"></script>
    <script type="text/javascript" src="./js/DrawHistoryValue.js?0331"></script>
    <script type="text/javascript" src="./js/DrawHistoryItem.js?0331"></script>
    <script type="text/javascript" src="./js/DrawHistory.js?0331"></script>
    <script type="text/javascript" src="./js/sortable.js?0331"></script>
    <!-- <script type="text/javascript" src="./js/random-org/key.js?0331"></script> -->
    <script type="text/javascript" src="./js/random-org/RandomApi.js?0331"></script>

    <!-- History API: http://balupton.com/projects/jquery-history -->
    <script type="text/javascript" src="./js/native.history.js"></script>

    <!-- with and without JS visibility and display -->
    <style type="text/css">
    .withJSvisible {visibility: hidden}
    .withJSdisplay {display:none}
    </style>
    <script language="JavaScript" type="text/javascript">
    document.write(String.fromCharCode(60),'style type="text/css"',String.fromCharCode(62),
            ' .withJSvisible {visibility:visible !important} ',
            ' .withoutJSvisible {visibility:hidden !important}  ',
            
            ' span.withJSdisplay {display:inline !important} div.withJSdisplay {display:block !important} ',
            ' .withoutJSdisplay {display:none !important} ',
            String.fromCharCode(60),'/style',String.fromCharCode(62)
    );
    </script>
    <?php echo $pv_controller->tpl->extraHeadTags?>
    <script language="JavaScript" type="text/javascript">
    var eventHistorySaveUrl = '<?php echo MainMenu::getModuleUrl('event_history', 'save')?>'.replace(/&amp;/g, '&');
    </script>
</head>
<body lang="pl">
    <div id="container">
        <div id="header">
            <div id="logo"></div><p><a href="index.php"><?php echo $pv_page_title?></a></p>
            <div id="stage"><?php
                switch ($configHelper->panel_stage)
                {
            case 'tests':
                echo 'Etap testów';
                break;
            case 'draw':
                echo 'Etap losowania';
                break;
            case 'results':
                echo 'Etap wyników';
                break;
                }
    ?></div>
        </div>
        <div id="menu">
    <?php echo $pv_mainMenu?>
        </div>
        <div id="content">
    <?php echo $pv_page_content?>
        </div>
        <div id="footer">
            <p>Copyright &copy;2014-2017 Maciej Jaros.</p>
        </div>

        <div id="randomApi-verify-dialog" title="Weryfikacja losowania" style="display: none">
            <p>Numer kolejny losowania: <span data-id="serialNumber"></span></p>
            <p>Zakres losowania: <span data-id="min"></span>-<span data-id="max"></span></p>
            <p>Wylosowane liczby: <span data-id="result"></span></p>
            <form action='https://api.random.org/verify' method='post' target="_blank">
                <input type='hidden' name='format' value='json' />
                <input type='hidden' name='random' value='' />
                <input type='hidden' name='signature' value='' />
                <input type='submit' value='Sprawdź na Random.org' />
            </form>
        </div>
        <div id="history-prepare-dialog" title="Przygotowywanie historii" style="display: none">
            <p>Trwa przygotowywanie historii. Proszę czekać.</p>
            <p>Jeśli komunikat nie zniknie - sprawdź połączenie z Internetem
                i odśwież stronę lub skontaktuj się z administratorem.</p>
        </div>
        <div id="history-delete-dialog" title="Skasować historię działań?" style="display: none">
            <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
                Kopia historii zostanie zapisana na serwerze, ale nie będziesz mógł(-a) jej przywrócić historii.</p>
            <p>Czy na pewno chcesz usunąć całą historię działań?</p>
            <ul data-id="buttons" style="display: none">
                <li data-id="delete">Skasuj historię</li>
                <li data-id="cancel">Anuluj</li>
            </ul>
        </div>
    </div>
    <script>
        (function($){
            function setHeight() {
                document.getElementById('content').style.cssText = '';
                var min = $(window).height() - ( $('#header').height() +  $('#footer').height() );
                // box-sizinig required(!)
                document.getElementById('content').style.cssText = 'min-height:'+ min +'px';
            }
            setHeight();
            window.addEventListener('load', setHeight);
            window.addEventListener('resize', setHeight);
        })(jQuery);
    </script>
</body>
</html>
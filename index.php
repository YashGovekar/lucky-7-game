<?php
session_start();
$balance_amount = !empty($_SESSION['balance_amount']) ? $_SESSION['balance_amount'] : 100;
if (isset($_POST['play'])) {
    $selected_choice = $_POST['selected_choice'];
    if (! empty($selected_choice)) {
        $balance_amount -= 10;

        $dice_a = rand(1, 6);
        $dice_b = rand(1, 6);

        $sum = $dice_a + $dice_b;

        $output = '';
        if ($selected_choice === 'below_seven') {
            if ($sum < 7) {
                $balance_amount += 20;
                $output = 'Congratulations! You win! Your balance is now: '.$balance_amount.' Rs.';
            } else {
                $output = 'Sorry, you lose! Your balance is now '.$balance_amount.' Rs.';
            }
        }
        if ($selected_choice === 'seven') {
            if ($sum === 7) {
                $balance_amount += 30;
                $output = 'Congratulations! You win! Your balance is now: '.$balance_amount.' Rs.';
            } else {
                $output = 'Sorry, you lose! Your balance is now '.$balance_amount.' Rs.';
            }
        }
        if ($selected_choice === 'above_seven') {
            if ($sum > 7) {
                $balance_amount += 20;
                $output = 'Congratulations! You win! Your balance is now: '.$balance_amount.' Rs.';
            } else {
                $output = 'Sorry, you lose! Your balance is now '.$balance_amount.' Rs.';
            }
        }
        $_SESSION['balance_amount'] = $balance_amount;
    } else {
        echo 'Please place your bet first!';
    }
}

if (isset($_POST['further_action'])) {
    $further_action = $_POST['further_action'];
    if ($further_action === 'reset') {
        $balance_amount = 100;
        $_SESSION['balance_amount'] = $balance_amount;
    }
}
?>
<html>
<head>
    <title>Dice Game</title>
    <meta charset="UTF-8">
    <style>
        body {
            background: black;
            color: white;
        }

        a {
            color: deeppink;
        }

        .flex {
            display: flex;
        }

        .gap-2 {
            gap: 2em;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function () {
            console.log('loaded');
        })

        $(document).on('click', '.choice-btn', function () {
            $('.choice-ip').val($(this).data('value'));
            $('#selected-bet').html($(this).html())
        })

        $(document).on('click', '.actions-btn', function () {
            $('#further_action_ip').val($(this).data('value'));
            $('#selected-action').html($(this).html())
        })

        $(document).on('click', '.actions-btn', function () {
            $(this).parent().submit();
        })
    </script>
</head>
<body>

    <h3>Welcome to Lucky 7 Game</h3>
    <h3>Place your bet (Rs 10):</h3>

    <h3><b>Current Balance: <?php echo $balance_amount ?></b></h3>
    <form method="post" action="index.php" class="flex gap-2">
        <input type="hidden" class="choice-ip" name="selected_choice"/>
        <div class="ip-container">
            <a class="btn choice-btn" href="#" data-value="below_seven">[Below 7]</a>
        </div>
        <div class="ip-container">
            <a class="btn choice-btn" href="#" data-value="seven">[7]</a>
        </div>
        <div class="ip-container">
            <a class="btn choice-btn" href="#" data-value="above_seven">[Above 7]</a>
        </div>
        <button class="btn" name="play" type="submit">[Play]</button>
    </form>
    <h4>Selected Bet: <span id="selected-bet"></span></h4>
    <?php
    if (isset($_POST['play'])) {
        ?>
        <h4>Selected Action: <span id="selected-action"></span></h4>
        <?php
    }
    ?>

    <div id="results">
        <h3>Game Results</h3>
        <?php
        if (! empty($output)) {
            ?>
            <h4>Dice 1: <?php if(!empty($dice_a)) { echo $dice_a; } ?> </h4>
            <h4>Dice 2:<?php if(!empty($dice_b)) { echo $dice_b; } ?> </h4>
            <h2><b><?php echo $output ?></b></h2>
            <?php
        }
        ?>
    </div>

    <form class="flex gap-2" method="post" action="index.php">
        <input type="hidden" id="further_action_ip" name="further_action" />
        <a class="actions-btn" data-value="reset" href="#">[Reset & Play again]</a>
        <a class="actions-btn" data-value="continue" href="#">[Continue playing]</a>
    </form>

</body>
</html>
<?php

include('inc/functions.php');

$record = $_GET['record'];

$entries = getEntries($record);

$alsoInclude = array();

$parts = explode(" ", $record);

$defaultRecords = array('a', 'mx');

foreach ($defaultRecords as $rec) {
    if (in_array($rec, $parts)) $alsoInclude[] = $rec;
}


include('inc/header.php'); ?>

    <a href="index.php?record=<?= urlencode($_GET['record']) ?>" class="btn btn-primary"
       style="float: right; margin-top: -20px">Modify Starter Record</a>

    <p>Your Starter Record: </p>
    <code style="white-space: inherit; display: block">
        <?= htmlentities($_GET['record']) ?>
    </code>
    <br>

    <hr>

    <form action="result.php" method="get" id="resolver">

        <h2>A &amp; MX</h2>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Record</th>
                <th style="width: 15%; text-align: center">Include</th>
                <th style="width: 15%; text-align: center">Resolve</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($defaultRecords as $rec) { ?>
                <tr>
                    <td>
                        <?= strtoupper($rec) ?>
                    </td>
                    <td style="text-align: center;">
                        <input type="checkbox" name="base[<?= $rec ?>][include]"
                               value="1" <?= in_array($rec, $alsoInclude) ? "checked" : "" ?>>
                    </td>
                    <td style="text-align: center;">
                        todo
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

        <?php foreach ($entries as $type => $entry) { ?>

            <h2><?= $type ?></h2>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Record</th>
                    <th style="width: 15%; text-align: center">Include</th>
                    <th style="width: 15%; text-align: center">Resolve</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($entry as $rec) { ?>
                    <tr>
                        <td><?= $rec ?></td>
                        <td style="text-align: center;">
                            <input type="checkbox" name="entries[<?= $type ?>][<?= $rec ?>][include]"
                                   value="1" checked>
                        </td>
                        <td style="text-align: center;">
                            <input type="checkbox"
                                   name="entries[<?= $type ?>][<?= $rec ?>][resolve]" <?= in_array($type, array('ip4', 'ip6')) ? "disabled" : "" ?>
                                   value="1">
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>

        <?php } ?>

        <h2>Strictness</h2>

        <select name="strictness">
            <option value="-">- Fail (Not compliant will be rejected)</option>
            <option value="!">~ SoftFail (Not compliant will be accepted but marked)</option>
            <option value="?">? Neutral (Mails will be probably accepted)</option>
        </select>

        <br>
        <hr>

        <p style="text-align:center">
            <button type="submit" class="btn btn-primary">Get New Record</button>
        </p>

    </form>

    <div id="result"></div>


    <script>

        $('#resolver').submit(function () {

            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: $(this).serialize(),
                success: function (data) {
                    el = $("<code style='white-space: inherit; display: block'>" + data + "</code>");
                    result = $('#result');
                    result.html('<p>New Record:</p>');
                    result.append(el);
                    result.append("<p>Characters: " + (data.length) + "</p>");
                }
            });
            return false;
        });

    </script>

<?php include('inc/footer.php'); ?>
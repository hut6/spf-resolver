<?php include('inc/header.php'); ?>

    <form method="get" action="resolve.php">

        <div class="form-group">

            <label for="exampleInputEmail1">SPF Record to parse:</label>

            <textarea name="record" class="form-control"
                      required><?= isset($_GET['record']) ? $_GET['record'] : "" ?></textarea>

        </div>

        <button type="submit" class="btn btn-primary">Continue</button>

    </form>

<?php include('inc/footer.php'); ?>
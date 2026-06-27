<div class="container mt-4">
    <h3 class="mb-4 text-center">My Certificates</h3>

    <div class="row">

        <?php while($row = mysqli_fetch_assoc($result)) { ?>

        <div class="col-md-4 mb-3">
            <div class="card shadow-sm border-0 rounded-4 p-3">

                <h5 class="fw-bold text-success">
                    <?= $row['course_name']; ?>
                </h5>

                <p class="mb-1">Score: <b><?= $row['score']; ?>%</b></p>
                <p class="text-muted small">
                    Date: <?= $row['date']; ?>
                </p>

                <a href="view-certificate.php?id=<?= $row['id']; ?>"
                   class="btn btn-success btn-sm mt-2 w-100">
                    View Certificate
                </a>

            </div>
        </div>

        <?php } ?>

    </div>
</div>
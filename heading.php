<div class="container">
    <div class="row">
        <div class="col-md-12 text-center">
            <!-- Foto de perfil -->
            <hr>
            <img class="pp" src="<?php echo $image; ?>" height="140" width="160" alt="Foto de perfil">
            <hr>
        </div>
        <div class="col-md-12">
            <!-- Información personal -->
            <hr>
            <p><strong>Información Personal</strong></p>
            <?php
            $query = $conn->query("SELECT * FROM members WHERE member_id = '$session_id'");
            $row = $query->fetch();
            $id = $row['member_id'];
            ?>
            <p><strong>Nombre:</strong> <?php echo $row['firstname'] . " " . $row['lastname']; ?></p>
            <p><strong>Género:</strong> <?php echo $row['gender']; ?></p>
            <p><strong>Dirección:</strong> <?php echo $row['address']; ?></p>
            <hr>
    </div>
</div>

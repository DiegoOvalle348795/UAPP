<?php include('header.php'); ?>    
<?php include('session.php'); ?>    
<body>
<?php include('navbar.php'); ?>

<div style="margin: 20px 0; text-align: center;">
    <button onclick="document.getElementById('createGroupForm').style.display='block'">Crear Grupo</button>
    <button onclick="document.getElementById('joinGroupForm').style.display='block'">Unirse a Grupo</button>
</div>

<div id="createGroupForm" style="display: none; margin: 20px; border: 1px solid #ccc; padding: 15px;">
    <h3>Crear Grupo</h3>
    <form action="create_group.php" method="POST">
        <input type="text" name="group_name" placeholder="Nombre del grupo" required>
        <button type="submit">Crear</button>
    </form>
</div>

<div id="joinGroupForm" style="display: none; margin: 20px; border: 1px solid #ccc; padding: 15px;">
    <h3>Unirse a un Grupo</h3>
    <form action="join_group.php" method="POST">
        <input type="text" name="group_code" placeholder="Código del grupo" required>
        <button type="submit">Unirse</button>
    </form>
</div>


<!-- Contenedor principal -->
<div style="width: 100%; margin: 0; padding: 0; box-sizing: border-box;">
    <!-- Contenedor de filas -->
    <div style="display: flex; flex-direction: row; width: 100%; box-sizing: border-box;">
        <!-- Columna Izquierda: Heading -->
        <div style="flex: 1; max-width: 30%; background-color: #f9f9f9; padding: 10px; border-right: 1px solid #ddd; box-sizing: border-box;">
            <h3>Tu</h3>
            <?php include('heading.php'); ?>
        </div>
        <h3>Tus Grupos</h3>
        <?php include('goups_home.php')?>
    </div>
  <!-- Columna Derecha: Publicaciones -->
<div style="flex: 2; max-width: 70%; background-color: #fff; padding: 10px; box-sizing: border-box;">
            <h3>Crea una peticion de ayuda</h3>
            <?php include('comments.php')?>
            <h1></h1>
            <h3>publicaciones de otras personas</h3>
            <?php
            $query = $conn->query("SELECT * FROM post LEFT JOIN members ON members.member_id = post.member_id ORDER BY post_id DESC");
            while ($row = $query->fetch()) {
                $posted_by = $row['firstname']." ".$row['lastname'];
                $posted_image = $row['image'];
                $id = $row['post_id'];
            ?>
            <div style="margin-bottom: 15px; border-bottom: 1px solid #ddd; padding-bottom: 10px;">
                <div style="display: flex; flex-direction: row; gap: 10px;">
                    <!-- Imagen del usuario -->
                    <div>
                        <img src="<?php echo $posted_image; ?>" style="width: 64px; height: 64px; border-radius: 50%;">
                    </div>
                    <!-- Detalles de la publicación -->
                    <div>
                        <h4 style="margin: 0;"><?php echo $posted_by; ?>
                            <small style="font-size: 12px; color: gray;">Publicado el <?php echo $row['date_posted']; ?></small>
                        </h4>
                        <p><?php echo $row['content']; ?></p>
                        <a href="delete_post.php<?php echo '?id='.$id; ?>" style="color: red; text-decoration: none;">Borrar</a>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
</div>
<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>

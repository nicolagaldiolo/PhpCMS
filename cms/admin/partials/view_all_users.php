<table class="table table-bordered table-hover">
    <thead>
    <tr>
        <th>Id</th>
        <th>Image</th>
        <th>Username</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Role</th>
        <th></th>
        <th></th>
        <th></th>
    </tr>
    </thead>

    <tbody>
    <?php

    $select = "SELECT * FROM users";
    $query = mysqli_query($connection, $select);
    $result = '';
    while($arr = mysqli_fetch_assoc($query)){
        extract($arr);

        $result .= "<tr>";
        $result .= "  <td>{$user_id}</td>";
        $result .= "  <td><img width=\"50\" src=\"../images/{$user_image}\" alt=\"\"></td>";
        $result .= "  <td>{$user_name}</td>";
        $result .= "  <td>{$user_firstname}</td>";
        $result .= "  <td>{$user_lastname}</td>";
        $result .= "  <td>{$user_email}</td>";
        $result .= "  <td>{$user_role}</td>";
        $result .= "  <td><a href='?source=edit_password&p_id={$user_id}'>Edit password</a></td>";
        $result .= "  <td><a href='?source=edit_user&p_id={$user_id}'>Edit</a></td>";
        $result .= "  <td><a class='confirmDeleteModal' href='#' data-toggle=\"modal\" data-target=\"#myModal\" rel='?delete={$user_id}'>Delete</a></td>";
        $result .= "</tr>";
    }

    echo $result;

    if(isset($_GET['delete'])){
        $delete_post_id = $_GET['delete'];
        $query = "DELETE FROM users WHERE user_id = {$delete_post_id}";
        $execute = mysqli_query($connection, $query);
        confirmQuery($execute);
        redirect($_SERVER['PHP_SELF']);
    }

    ?>



    </tbody>
</table>
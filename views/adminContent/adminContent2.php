
<div class="report-container">
            <div class="report-header d-flex">
                <div class="text">Administrate groups</div>
                <span class="d-flex">
                    <form method="post" action="" class="mx-1">
                    <button name="changeFilter" type="submit" class="btn btn-success"><?php if ($_SESSION['sort_order'] == 1){echo "ASC";} else {echo "DESC";}  ?></button>
                </form>
                <form method="post" action="" class="mx-1">
                    <button name="addGroup" type="submit" class="btn btn-success">Add Group</button>
                </form>
                </span>

                <?php
                    if(isset($_POST['addGroup'])) {
                        $groupName = "group" . $_SESSION['groupCounter'];

                        $html = $admin->createGroup();

                    }
                    if(isset($_POST['changeFilter'])) {
                        $_SESSION['sort_order'] *= -1;
                    }
                foreach ($_POST as $key => $value) {
                    $parts = explode('_', $key);
                    if (count($parts) === 2) {
                        $action = $parts[0];
                        $group = $parts[1];
                            switch ($action) {
                                case 'delete':
                                    $admin->deleteGroup($group);

                                    break;
                                case 'view':

                                    break;
                                case 'email':
                                    $admin->emailUsersInGroup($group, "Hello friends" , "This is a php email");
                                    break;
                                case 'ban':
                                    $admin->banUsersInGroup($group);
                                    break;
                                default:
                            }
                        }

                }

                    ?>
            </div>
            <div class="report-body">
                <div class="report-topic-heading">
                    <h3 class="t-op">Groups</h3>
                </div>

                <div class="items">
                        <?php echo $admin->loadGroups($_SESSION['sort_order']); ?>
                    </ul>
                </div>
            </div>
        </div>

</div>
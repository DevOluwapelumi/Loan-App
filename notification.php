<?php
  
  // SQL query to fetch domestic transfer records for the user
  $sql = "SELECT * FROM notification WHERE user_id = (SELECT id FROM user_registration WHERE username = ?) ORDER BY id DESC LIMIT 5";
  $stmt = $conn->prepare($sql);
  
  if ($stmt === false) {
      echo json_encode(array("error" => "Error in preparing the SQL query."));
      exit();
  }
  
  $stmt->bind_param("s", $username);
  $stmt->execute();
  
  $result = $stmt->get_result();
  
  // Check if there are any records
  if ($result->num_rows > 0) {
      $serialNumber = 1;
  
      // Fetch and output transfer records
      while ($row = $result->fetch_assoc()) {
        ?>
                        <div class="notification-scroll">
                            <div class="dropdown-item">
                                <div class="media ">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round" class="feather feather-activity">
                                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                                    </svg>
                                    <div class="media-body">
                                        <div class="data-info">
                                             <p class=""><?php echo $row['value']?></p>
                                        </div>

                                        <div class="icon-status">
                                            <?php if($row['type'] == 2){?>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>                                        </div>
                             <?php }?> 
                                        </div>
                                </div>
                            </div>

                        </div>

                        <?php }}else{
                         echo "No Recent Notification";   
                        }
                            ?>
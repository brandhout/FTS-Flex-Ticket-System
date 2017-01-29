<?php
    
    
  $connectie = verbinddatabase();    
   $query = $connectie->prepare("SELECT * FROM ticket");
$query->execute();
$query->store_result();
$rowsat = $query->num_rows;



$one=1;
$query1 = $connectie->prepare("SELECT * FROM ticket WHERE inBehandeling = ?");
$query1->bind_param('s', $one);
$query1->execute();
$query1->store_result();
$rowsot = $query1->num_rows;

   
   $query2 = $connectie->prepare("SELECT * FROM account");
$query2->execute();
$query2->store_result();
$rowsa = $query2->num_rows;

$one=0;
$query3 = $connectie->prepare("SELECT * FROM ticket WHERE inBehandeling = ?");
$query3->bind_param('s', $one);
$query3->execute();
$query3->store_result();
$rowsbt = $query3->num_rows;

?>

<html>  
             <div class="container-fluid">
  <div class="row mb-3">
<?php
    switch ($_SESSION['isAdmin']) { 
                case "1": echo '     
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-success">
                        <div class="card-block bg-success">
                            <div class="rotate">
                                <i class="fa fa-user fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">account</h6>
                            <h1 class="display-1">'.$rowsa.'</h1>
                        </div>
                    </div>
                </div>
                    				' ;
                break;

                case "0":
                break;

                default:
                break;
            }

?>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-danger">
                        <div class="card-block bg-danger">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">openstaande tickets</h6>
                            <h1 class="display-2"><?php echo $rowsot ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-info">
                        <div class="card-block bg-info">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">alle tickets</h6>
                            <h1 class="display-3"><?php echo $rowsat; ?></h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card card-inverse card-warning">
                        <div class="card-block bg-warning">
                            <div class="rotate">
                                <i class="fa fa-ticket fa-5x"></i>
                            </div>
                            <h6 class="text-uppercase">voltooide tickets</h6>
                            <h1 class="display-4"><?php echo $rowsbt ?></h1>
                        </div>
                    </div>
                </div>
            </div>   

             </div>           
    
    
    
    
</html>


<section class="tables no-padding-top">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">

                    <div class="card-header d-flex align-items-center">
                        <h3 class="h4"><?php echo $months[$_POST["month"]-1] . ", " . $_POST["year"] ?> Attendance</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                <tr>
                                    <th style="width: 16%">#</th>
                                    <th style="width: 36%">Name</th>
                                    <th style="width: 16%">Presents (inc. Lates)</th>
                                    <th style="width: 16%">Lates </th>
                                    <th style="width: 16%">Leaves </th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php
                                    $i = 1;
                                    $totalDays = countDays($_POST["year"], $_POST["month"], array(0, 6));

                                    while($row = $result->fetch_assoc()){
                                        echo "<tr><th scope='row'>$i</th>";
                                        echo "<td><a href='empEdit.php?id=".$row["uid"]."' >".$row["name"]."</a></td>";
                                        echo "<td>".$row["presents"]."</td>";
                                        echo "<td>".$row["lates"]."</td>";
                                        echo "<td>". ($totalDays - $row["presents"]) ."</td></tr>";
                                        $i++;
                                    }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
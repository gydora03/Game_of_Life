<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Game of Life</title>

    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Lora&display=swap" rel="stylesheet">

    <script type="text/javascript" src="js/game.js"></script>
</head>

<body>

    <?php 
        require "index.html";
    ?>

    
    <div class="row mt-4">
        <div class="col-sm text-center align-self-center">
            <div class="row">
                <div class="col text-center align-self-center">
                    <button type="button" class="btn btn-dark" onclick="setTime();">Auto play</button>
                    <button type="button" class="btn btn-dark" onclick="clearInterval(interval);">Stop</button>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col text-center align-self-center">
                    <button type="button" class="btn btn-dark" onclick="stepping();">Stepping</button>
                </div>
            </div>
        </div>

        <div class="col-sm text-center">
            <canvas id="canvas"></canvas>

            <?php 
                $size = 810;
                $scale = 6;
                $resolution = $size / $scale;
                $center = ($resolution - 1) / 2 + 1; 

                $state = array();
                for ($i=0; $i < $resolution; $i++) { 
                    for ($j=0; $j < $resolution; $j++) { 
                        $state[$i][$j] = 1;
                    }
                }

                $buttonName = $_POST["btnName"] . ".lif";

                $file = fopen("lif_files/" . $buttonName, "r") or exit("Unable to open file!");
                
                while (!feof($file)) {
                    $line = fgets($file);
                    
                    if (strpos($line, "#P") === 0) {

                        $coordinate = explode(" ", strstr($line, " "));
                        $x = intval($coordinate[1]);
                        $y = intval($coordinate[2]);

                        if ($x < 0 || $x > 0) {
                            $colCell = $center + $x;
                        } else {
                            $colCell = $center;
                        }

                        if ($y < 0) {
                            $rowCell = $center + abs($y);
                        } else if ($y > 0) {
                            $rowCell = $center - $y;
                        } else {
                            $rowCell = $center;
                        }

                    }

                    if ($line[0] === "." || $line[0] === "*") {
                        for ($i = 0; $i < strlen($line)-1; $i++){
                            
                            if ($line[$i] == "*") {
                                $state[$colCell+$i][$rowCell] = 0;
                            }
                        }

                        $rowCell = $rowCell + 1;
                        
                    }
                    
                }

                /*for ($i=0; $i < $resolution; $i++) { 
                    for ($j=0; $j < $resolution; $j++) { 
                        echo $state[$i][$j] . " ";
                    }
                    echo "<br>";
                }*/

                //$state[26][26] = 0;
                fclose($file);

            ?>
            
            <script type="text/javascript">
                const canvas = document.getElementById("canvas");
                const context = canvas.getContext("2d");
                const size = 810;
                const scale = 6;
                const resolution = size / scale;
                let grid;
                let numOfGeneration = 0;
                var interval;
                setup();

                let state = <?php echo json_encode($state); ?>;
                for (let i = 0; i < resolution; i++) {
                    for (let j = 0; j < resolution; j++) {
                        grid[i][j] = state[i][j];
                    }
                }

                drawCells();        
            </script>

        </div>

        <div class="col-sm text-center align-self-center" id="generation">
            <p class="font-weight-bold">Current generation:</p>
            <p id="gen"></p>
        </div>
    </div> 

    
    

</body>
</html>
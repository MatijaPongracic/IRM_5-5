<?php
session_start();
date_default_timezone_set("Europe/Zagreb");
$timeout_duration = 600; // 10 minuta

if (isset($_SESSION['email']) && 
          isset($_SESSION['user_id'])) {
			// session timeout
			if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
				session_unset();
				session_destroy();
				header("Location: login.php?error=Session Timeout. Please login again.");
				exit;
			}
			$_SESSION['last_activity'] = time();
			
			$putanja = "log_messages.txt";
			$log_messages = [];
			if (file_exists($putanja)) {
				$old_messages = file($putanja, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
				foreach ($old_messages as $red) {
					$log_messages[] = $red;
				}
			}
			?>
<!DOCTYPE html>
<html>
<head>
<title>Projektni zadatak</title>

<style>
body {
    background-color: #33d1ff;
    padding: 30px;
    font-family: Calibri Light;
    color: #d9e9ff;
}
#naslov_zadatka {
    position: absolute;
    top: 75px;
    left: 50%;
    width: 700px;
    background: #002a5c;
    color: #ffffff;
    z-index: 1;
    font-size: 60px;
    font-family: 'Calibri Light', sans-serif;
    transform: translate(-50%, -50%);
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    transition: background-color 0.3s ease, transform 0.3s ease;
}

#naslov_zadatka:hover {
    background-color: #004080;
    transform: translate(-50%, -50%) scale(1.05);
}

#tekst_trans { position: absolute; top: 200px; left: 50px; width: 100px; height: 20px; background: #002a5c; z-index: 1; color: #d9e9ff; }
#neg_x_trans { position: absolute; top: 280px; left: 50px; width: 75px; height: 40px; z-index: 1; color: #d9e9ff; }
#poz_x_trans { position: absolute; top: 230px; left: 50px; width: 75px; height: 40px; z-index: 1; color: #d9e9ff; }
#neg_y_trans { position: absolute; top: 380px; left: 50px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#poz_y_trans { position: absolute; top: 330px; left: 50px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#neg_z_trans { position: absolute; top: 480px; left: 50px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#poz_z_trans { position: absolute; top: 430px; left: 50px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#tekst_rot { position: absolute; top: 200px; left: 150px; width: 100px; background: #002a5c; z-index: 1; color: #d9e9ff; }
#neg_x_rot { position: absolute; top: 280px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#poz_x_rot { position: absolute; top: 230px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#neg_y_rot { position: absolute; top: 380px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#poz_y_rot { position: absolute; top: 330px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#neg_z_rot { position: absolute; top: 480px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#poz_z_rot { position: absolute; top: 430px; left: 150px; width: 75px; height: 25px; z-index: 1; color: #d9e9ff; }
#tekst_zglobovi { position: absolute; top: 200px; left: 300px; width: 200px; background: #002a5c; z-index: 1; color: #d9e9ff; }
#neg_zglob_1 { position: absolute; top: 230px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#neg_zglob_2 { position: absolute; top: 280px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#neg_zglob_3 { position: absolute; top: 330px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#neg_zglob_4 { position: absolute; top: 380px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#neg_zglob_5 { position: absolute; top: 430px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#neg_zglob_6 { position: absolute; top: 480px; left: 300px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#tekst_alat { position: absolute; top: 200px; left: 500px; width: 200px; background: #002a5c; z-index: 1; color: #d9e9ff; }
#x { position: absolute; top: 230px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#y { position: absolute; top: 280px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#z { position: absolute; top: 330px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#rx { position: absolute; top: 380px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#ry { position: absolute; top: 430px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#rz { position: absolute; top: 480px; left: 500px; width: 75px; height: 25px; background: #efefef; z-index: 1; color: #000000; }
#tekst_program { position: absolute; top: 200px; left: 800px; width: 200px; background: #002a5c; z-index: 1; color: #d9e9ff; }
#program_stop { position: absolute; top: 380px; left: 800px; width: 160px; z-index: 1; color: #d9e9ff; }
#program_load { position: absolute; top: 230px; left: 800px; width: 125px; z-index: 1; color: #d9e9ff; }
#program_play { position: absolute; top: 330px; left: 800px; width: 125px; z-index: 1; color: #d9e9ff; }
#logout_button { position: absolute; top: 20px; right: 50px; background-color: #005bb5; color: #ffffff; font-size: 18px; font-family: Calibri Light; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; z-index: 2; }
#postavi_zglobove { position: absolute; top: 530px; left: 300px; background-color: #005bb5; color: #ffffff; font-size: 18px; font-family: Calibri Light; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; z-index: 2; }
#postavi_alat { position: absolute; top: 530px; left: 500px; background-color: #005bb5; color: #ffffff; font-size: 18px; font-family: Calibri Light; text-decoration: none; padding: 10px 20px; border-radius: 5px; border: none; cursor: pointer; z-index: 2; }
#tekst_input {
    position: absolute;
    top: 650px;
    left: 100px;
    width: 750px;
    z-index: 1;
    color: #d9e9ff;
}
#input_text {
    width: 100%;
    height: 150px;
    background-color: #efefef;
    color: #002a5c;
    font-family: Calibri Light;
    font-size: 14px;
    border: 1px solid #005bb5;
    padding: 10px;
    resize: vertical;
    overflow-y: auto;
}
#tablica {
    position: absolute;
    top: 200px;
    right: 50px;
    width: auto;
    background-color: #003366;
    border-collapse: collapse;
}

#tablica table {
    width: 100%;
    border: 1px solid #005bb5;
}

#tablica td {
    padding: 10px;
    text-align: center;
    border: 1px solid #005bb5;
    font-family: 'Calibri Light', sans-serif;
    color: #d9e9ff;
    background-color: #002a5c;
}

#tablica td[id*='-pos'] {
    background-color: #003366;
}

#tablica tr:nth-child(even) {
    background-color: #002244;
}

#tablica tr:hover {
    background-color: #001a33;
}

#tablica #status-pos {
    background-color: #004080;
    color: #ffffff;
    font-weight: bold;
}
#tablica tr:last-child { height: 70px; }


</style>
</head>

<body>
<div id="tekst_trans" >TRANSLATION</div>
<div id="tekst_rot" >ROTATION</div>
<div id="naslov_zadatka" > UPRAVLJANJE UR-om</div>
<div id="neg_x_trans" > <form action="index.php?naredba=100" method="post"> <input type="submit" name="gumb_x_neg" value="- X [mm]    "/> <label for="pomak_x_neg"> </label> <input type="text" name="pomak_x_neg" id="pomak_x_neg" value = "50" size="5" /> </form> </div>
<div id="poz_x_trans" > <form action="index.php?naredba=101" method="post"> <input type="submit" name="gumb_x_poz" value="+ X [mm]   "/> <label for="pomak_x_poz"> </label> <input type="text" name="pomak_x_poz" id="pomak_x_poz" value = "50" size="5" /> </form> </div>
<div id="neg_y_trans" > <form action="index.php?naredba=102" method="post"> <input type="submit" name="gumb_y_neg" value="- Y [mm]    "/> <label for="pomak_y_neg"> </label> <input type="text" name="pomak_y_neg" id="pomak_y_neg" value = "50" size="5" /> </form> </div>
<div id="poz_y_trans" > <form action="index.php?naredba=103" method="post"> <input type="submit" name="gumb_y_poz" value="+ Y [mm]   "/> <label for="pomak_y_poz"> </label> <input type="text" name="pomak_y_poz" id="pomak_y_poz" value = "50" size="5" /> </form> </div>
<div id="neg_z_trans" > <form action="index.php?naredba=104" method="post"> <input type="submit" name="gumb_z_neg" value="- Z [mm]    "/> <label for="pomak_z_neg"> </label> <input type="text" name="pomak_z_neg" id="pomak_z_neg" value = "50" size="5" /> </form> </div>
<div id="poz_z_trans" > <form action="index.php?naredba=105" method="post"> <input type="submit" name="gumb_z_poz" value="+ Z [mm]   "/> <label for="pomak_z_poz"> </label> <input type="text" name="pomak_z_poz" id="pomak_z_poz" value = "50" size="5" /> </form> </div>
<div id="neg_x_rot" > <form action="index.php?naredba=106" method="post"><input type="submit" name="gumb_rx_neg" value="- RX [°]"/> <label for="pomak_rx_neg"> </label> <input type="text" name="pomak_rx_neg" id="pomak_rx_neg" value = "30" size="5" /> </form> </div>
<div id="poz_x_rot" > <form action="index.php?naredba=107" method="post"><input type="submit" name="gumb_rx_poz" value="+ RX [°]"/> <label for="pomak_rx_poz"> </label> <input type="text" name="pomak_rx_poz" id="pomak_rx_poz" value = "30" size="5" /> </form> </div>
<div id="neg_y_rot" > <form action="index.php?naredba=108" method="post"><input type="submit" name="gumb_ry_neg" value="- RY [°]"/> <label for="pomak_ry_neg"> </label> <input type="text" name="pomak_ry_neg" id="pomak_ry_neg" value = "30" size="5" /> </form> </div>
<div id="poz_y_rot" > <form action="index.php?naredba=109" method="post"><input type="submit" name="gumb_ry_poz" value="+ RY [°]"/> <label for="pomak_ry_poz"> </label> <input type="text" name="pomak_ry_poz" id="pomak_ry_poz" value = "30" size="5" /> </form> </div>
<div id="neg_z_rot" > <form action="index.php?naredba=110" method="post"><input type="submit" name="gumb_rz_neg" value="- RZ [°]"/> <label for="pomak_rz_neg"> </label> <input type="text" name="pomak_rz_neg" id="pomak_rz_neg" value = "30" size="5" /> </form> </div>
<div id="poz_z_rot" > <form action="index.php?naredba=111" method="post"><input type="submit" name="gumb_rz_poz" value="+ RZ [°]"/> <label for="pomak_rz_poz"> </label> <input type="text" name="pomak_rz_poz" id="pomak_rz_poz" value = "30" size="5" /> </form> </div>
<div id="tekst_input">
<textarea id="input_text" name="input_text" rows="10" cols="50" readonly><?php
        echo implode("\n", $log_messages);
    ?></textarea></div>

<form action="index.php?naredba=200" method="post">
  <div id="tekst_zglobovi">JOINT POSITIONS</div>
  <div id="neg_zglob_1">
    <label for="pomak_z1_neg">J1 [°]</label>
    <input type="text" name="pomak_z1_neg" id="pomak_z1_neg" 
           value="<?php echo isset($_POST['pomak_z1_neg']) ? $_POST['pomak_z1_neg'] : '30'; ?>" size="5" />
  </div>
  <div id="neg_zglob_2">
    <label for="pomak_z2_neg">J2 [°]</label>
    <input type="text" name="pomak_z2_neg" id="pomak_z2_neg" 
           value="<?php echo isset($_POST['pomak_z2_neg']) ? $_POST['pomak_z2_neg'] : '-60'; ?>" size="5" />
  </div>
  <div id="neg_zglob_3">
    <label for="pomak_z3_neg">J3 [°]</label>
    <input type="text" name="pomak_z3_neg" id="pomak_z3_neg" 
           value="<?php echo isset($_POST['pomak_z3_neg']) ? $_POST['pomak_z3_neg'] : '60'; ?>" size="5" />
  </div>
  <div id="neg_zglob_4">
    <label for="pomak_z4_neg">J4 [°]</label>
    <input type="text" name="pomak_z4_neg" id="pomak_z4_neg" 
           value="<?php echo isset($_POST['pomak_z4_neg']) ? $_POST['pomak_z4_neg'] : '-120'; ?>" size="5" />
  </div>
  <div id="neg_zglob_5">
    <label for="pomak_z5_neg">J5 [°]</label>
    <input type="text" name="pomak_z5_neg" id="pomak_z5_neg" 
           value="<?php echo isset($_POST['pomak_z5_neg']) ? $_POST['pomak_z5_neg'] : '-75'; ?>" size="5" />
  </div>
  <div id="neg_zglob_6">
    <label for="pomak_z6_neg">J6 [°]</label>
    <input type="text" name="pomak_z6_neg" id="pomak_z6_neg" 
           value="<?php echo isset($_POST['pomak_z6_neg']) ? $_POST['pomak_z6_neg'] : '120'; ?>" size="5" />
  </div>
  <input type="hidden" name="naredba" value="200" />
  <button type="submit" id="postavi_zglobove">SET</button>
</form>

<form action="index.php?naredba=250" method="post">
  <div id="tekst_alat">TCP POSE</div>
  <div id="x">
    <label for="pos1">X [mm]</label>
    <input type="text" name="pos1" id="pos1" 
           value="<?php echo isset($_POST['pos1']) ? $_POST['pos1'] : '-350'; ?>" size="5" />
  </div>
  <div id="y">
    <label for="pos2">Y [mm]</label>
    <input type="text" name="pos2" id="pos2" 
           value="<?php echo isset($_POST['pos2']) ? $_POST['pos2'] : '-420'; ?>" size="5" />
  </div>
  <div id="z">
    <label for="pos3">Z [mm]</label>
    <input type="text" name="pos3" id="pos3" 
           value="<?php echo isset($_POST['pos3']) ? $_POST['pos3'] : '220'; ?>" size="5" />
  </div>
  <div id="rx">
    <label for="pos4">RX [°]</label>
    <input type="text" name="pos4" id="pos4" 
           value="<?php echo isset($_POST['pos4']) ? $_POST['pos4'] : '270'; ?>" size="5" />
  </div>
  <div id="ry">
    <label for="pos5">RY [°]</label>
    <input type="text" name="pos5" id="pos5" 
           value="<?php echo isset($_POST['pos5']) ? $_POST['pos5'] : '-180'; ?>" size="5" />
  </div>
  <div id="rz">
    <label for="pos6">RZ [°]</label>
    <input type="text" name="pos6" id="pos6" 
           value="<?php echo isset($_POST['pos6']) ? $_POST['pos6'] : '0'; ?>" size="5" />
  </div>
  <input type="hidden" name="naredba" value="250" />
  <button type="submit" id="postavi_alat">SET</button>
</form>

<div id="tekst_program" >PROGRAM</div>
<div id="program_stop" > <form action="index.php?naredba=402" method="post"><input type="submit" name="ProgStop" value="STOP"/> </form> </div>
<div id="program_load">
  <form action="index.php?naredba=400" method="post">
    <input type="submit" name="ProgLoad" value="LOAD PROGRAM" />

    <select name="naziv_programa_select" id="naziv_programa_select" onchange="updateTextInput()">
      <option value="">-- Choose a program --</option>
      <option value="program1">program1</option>
      <option value="program2">program2</option>
      <option value="novi_program">novi_program</option>
    </select>


    <input type="text" name="naziv_programa" id="naziv_programa" size="16" />
  </form>
</div>

<script>
  // Kada korisnik odabere vrijednost iz padajućeg izbornika, ažurira se tekstualno polje
  function updateTextInput() {
    const select = document.getElementById("naziv_programa_select");
    const input = document.getElementById("naziv_programa");
    input.value = select.value; // Postavlja vrijednost tekstualnog polja prema izboru
  }
</script>

<div id="program_play" > <form action="index.php?naredba=401" method="post"><input type="submit" name="ProgStart" value="START PROGRAM"/> </form> </div>
<a href="logout.php" id="logout_button">Logout</a>

<div id="tablica">
    <table border="1">
      <tr>
        <td>X</td>
        <td id="x-pos" style="width: 150px;"></td>
        <td>J1</td>
        <td id="j1-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td>Y</td>
        <td id="y-pos" style="width: 150px;"></td>
        <td>J2</td>
        <td id="j2-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td>Z</td>
        <td id="z-pos" style="width: 150px;"></td>
        <td>J3</td>
        <td id="j3-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td>RX</td>
        <td id="rx-pos" style="width: 150px;"></td>
        <td>J4</td>
        <td id="j4-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td>RY</td>
        <td id="ry-pos" style="width: 150px;"></td>
        <td>J5</td>
        <td id="j5-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td>RZ</td>
        <td id="rz-pos" style="width: 150px;"></td>
        <td>J6</td>
        <td id="j6-pos" style="width: 150px;"></td>
      </tr>
      <tr>
        <td id="status-pos" colspan="4" style="width: 150px;"></td>
      </tr>
    </table>
</div>


<?php
function getRobotData() {
    // Pokrenite Python skripte i dohvacanje izlaza
    $output = shell_exec('python rtde_script.py');
    
    error_log("Python izlaz: " . $output);

    if ($output === null) {
        die("Greška: Python skripta nije vratila odgovor.");
    }

    $data = json_decode($output, true);

    if ($data === null) {
        error_log("Nevalidan JSON: $output");
        die("Greška: Nevalidan JSON odgovor iz Python skripte.");
    }

    $tcp_pose = isset($data['tcp_pose']) && is_array($data['tcp_pose']) ? implode(", ", $data['tcp_pose']) : "Nema podataka";
    $joint_positions = isset($data['joint_positions']) && is_array($data['joint_positions']) ? implode(", ", $data['joint_positions']) : "Nema podataka";

    $dashboard_response = "Nije moguce povezati se sa Dashboard serverom.";
    $socket = fsockopen('192.168.40.50', 29999, $errno, $errstr, 5);

    if ($socket) {
        fgets($socket);
        fwrite($socket, "running\n");
        $dashboard_response = trim(fgets($socket));
		if($dashboard_response == "Program running: true"){
			fwrite($socket, "get loaded program\n");
			$dashboard_response = trim(fgets($socket));
			$dashboard_response = str_replace("Loaded program", "Program running", $dashboard_response);
		}
		elseif($dashboard_response == "Program running: false"){
			$dashboard_response = "No program running";
		}
        fclose($socket);
    } else {
        error_log("Socket greška ($errno): $errstr");
    }

    return "TCP pozicija: [$tcp_pose]\nZglobne pozicije: [$joint_positions]\nStatus robota: $dashboard_response";
}

if (isset($_GET['ajax']) && $_GET['ajax'] === 'true') {
    echo getRobotData();
    exit;
}
?>

<script>
    // Funkcija za dohvat podataka i azuriranje tablice
	function updateTable() {
		// AJAX zahtjev
		fetch('index.php?ajax=true')
			.then(response => {
				if (!response.ok) {
					throw new Error('Greška pri dohvaćanju podataka');
				}
				return response.text();
			})
			.then(data => {
				// Parsiranje tekstualnog odgovora (TCP pozicija i zglobne pozicije)
				const tcpRegex = /TCP pozicija: \[(.*?)\]/;
				const jointRegex = /Zglobne pozicije: \[(.*?)\]/;
				const dashboardRegex = /Status robota: (.*)/;

				const tcpMatch = data.match(tcpRegex);
				const jointMatch = data.match(jointRegex);
				const dashboardMatch = data.match(dashboardRegex);

				if (tcpMatch && jointMatch) {
					const tcpPose = tcpMatch[1].split(', ');
					const jointPositions = jointMatch[1].split(', ');

					// Azuriranje vrijednosti u tablici
					document.getElementById('x-pos').innerText = tcpPose[0] || '';
					document.getElementById('y-pos').innerText = tcpPose[1] || '';
					document.getElementById('z-pos').innerText = tcpPose[2] || '';
					document.getElementById('rx-pos').innerText = tcpPose[3] || '';
					document.getElementById('ry-pos').innerText = tcpPose[4] || '';
					document.getElementById('rz-pos').innerText = tcpPose[5] || '';

					document.getElementById('j1-pos').innerText = jointPositions[0] || '';
					document.getElementById('j2-pos').innerText = jointPositions[1] || '';
					document.getElementById('j3-pos').innerText = jointPositions[2] || '';
					document.getElementById('j4-pos').innerText = jointPositions[3] || '';
					document.getElementById('j5-pos').innerText = jointPositions[4] || '';
					document.getElementById('j6-pos').innerText = jointPositions[5] || '';
				} else {
					console.error('Neispravan format odgovora:', data);
				}

				if (dashboardMatch) {
					const dashboardResponse = dashboardMatch[1] || "Nema podataka";
					document.getElementById('status-pos').innerText = dashboardResponse;
				}
			})
			.catch(error => {
				console.error('Greška:', error);
			});
	}

	setInterval(updateTable, 100);

    function log_input(text) {
        const logBox = document.getElementById("input_text");
        logBox.value += "\n" + text; // Dodavanje teksta u novi red
        logBox.scrollTop = logBox.scrollHeight;
    }
</script>

<?php
 function add_log($tekst) {
    $file = fopen("log_messages.txt", "a");
    if ($file) {
        fwrite($file, $tekst);
        fclose($file);
		}
	}
 
 $datoteka = fopen("log_messages.txt", "a");
 $val=0;
 	$val = isset($_GET['naredba']) ? $_GET['naredba'] : 0;
		$trenutno_vrijeme = date("d-m-y H:i:s");
		if($val == 100){
			$log_pomak= $_REQUEST['pomak_x_neg'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_x_neg= $log_pomak / 1000;
			$program_x_neg = "def program_x_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[0]=poz_tcp2[0]-".$pomak_x_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - X = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - X = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_x_neg;
			} 
		elseif($val == 101){
			$log_pomak= $_REQUEST['pomak_x_poz'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_x_poz= $log_pomak / 1000;
			$program_x_poz = "def program_x_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[0]=poz_tcp2[0]+".$pomak_x_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + X = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + X = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_x_poz;
			} 
		elseif($val == 102){
			$log_pomak= $_REQUEST['pomak_y_neg'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_y_neg= $log_pomak / 1000;
			$program_y_neg = "def program_y_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[1]=poz_tcp2[1]-".$pomak_y_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - Y = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - Y = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_y_neg;
			} 
		elseif($val == 103){
			$log_pomak= $_REQUEST['pomak_y_poz'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_y_poz= $log_pomak / 1000;
			$program_y_poz = "def program_y_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[1]=poz_tcp2[1]+".$pomak_y_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + Y = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + Y = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_y_poz;
			} 
		elseif($val == 104){
			$log_pomak= $_REQUEST['pomak_z_neg'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_z_neg= $log_pomak / 1000;
			$program_z_neg = "def program_z_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[2]=poz_tcp2[2]-".$pomak_z_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - Z = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost - Z = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_z_neg;
			} 
		elseif($val == 105){
			$log_pomak= $_REQUEST['pomak_z_poz'];
			if ($log_pomak > 100) {
				$log_pomak = 100;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_z_poz= $log_pomak / 1000;
			$program_z_poz = "def program_z_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[2]=poz_tcp2[2]+".$pomak_z_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + Z = " . addslashes($log_pomak) . " mm');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Translacija za vrijednost + Z = " . addslashes($log_pomak) . " mm\n";
			add_log($novi_tekst);
			$message=$program_z_poz;
			} 		
		elseif($val == 106){
			$log_pomak= $_REQUEST['pomak_rx_neg'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_rx_neg= $log_pomak * (M_PI / 180);
			$program_rx_neg = "def program_rx_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[3]=poz_tcp2[3]-".$pomak_rx_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RX = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RX = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_rx_neg;
			} 
		elseif($val == 107){
			$log_pomak= $_REQUEST['pomak_rx_poz'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_rx_poz= $log_pomak * (M_PI / 180);
			$program_rx_poz = "def program_rx_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[3]=poz_tcp2[3]+".$pomak_rx_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RX = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RX = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_rx_poz;
			} 	
		elseif($val == 108){
			$log_pomak= $_REQUEST['pomak_ry_neg'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_ry_neg= $log_pomak * (M_PI / 180);
			$program_ry_neg = "def program_ry_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[4]=poz_tcp2[4]-".$pomak_ry_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RY = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RY = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_ry_neg;
			} 
		elseif($val == 109){
			$log_pomak= $_REQUEST['pomak_ry_poz'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_ry_poz= $log_pomak * (M_PI / 180);
			$program_ry_poz = "def program_ry_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[4]=poz_tcp2[4]+".$pomak_ry_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RY = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RY = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_ry_poz;
			}
		elseif($val == 110){
			$log_pomak= $_REQUEST['pomak_rz_neg'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_rz_neg= $log_pomak * (M_PI / 180);
			$program_rz_neg = "def program_rz_neg():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[5]=poz_tcp2[5]-".$pomak_rz_neg."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RZ = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost - RZ = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_rz_neg;
			} 
		elseif($val == 111){
			$log_pomak= $_REQUEST['pomak_rz_poz'];
			if ($log_pomak > 45) {
				$log_pomak = 45;
			}
			elseif ($log_pomak < 0) {
				$log_pomak = 0;
			}
			$pomak_rz_poz= $log_pomak * (M_PI / 180);
			$program_rz_poz = "def program_rz_poz():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n  poz_tcp2[5]=poz_tcp2[5]+".$pomak_rz_poz."\n  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RZ = " . addslashes($log_pomak) . "°');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Rotacija za vrijednost + RZ = " . addslashes($log_pomak) . "°\n";
			add_log($novi_tekst);
			$message=$program_rz_poz;
			}
		elseif ($val == 200) {
			$program = "def program_combined():\n  poz_j=get_actual_joint_positions()\n  poz_2j=poz_j\n";
			for ($i = 1; $i <= 6; $i++) {
				$param_name = "pomak_z" . $i . "_neg";
				if (isset($_REQUEST[$param_name])) {
					$pomak_stupnjevi = $_REQUEST[$param_name];
					if ($pomak_stupnjevi > 360) {
						$pomak_stupnjevi = 360;
					}
					elseif ($pomak_stupnjevi < -360) {
						$pomak_stupnjevi = -360;
					}
					$pomak = $pomak_stupnjevi * (M_PI / 180);
					$program .= "  poz_2j[" . ($i - 1) . "]=" . $pomak . "\n";
				}
			}
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Joint positions set');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Joint positions set\n";
			add_log($novi_tekst);
			$program .= "  movej(poz_2j,a=1,v=1,t=0,r=0)\nend\n";
			$message = $program;
			}
		elseif ($val == 250) {
			$program = "def program_combined():\n  poz_tcp=get_actual_tcp_pose()\n  poz_tcp2=poz_tcp\n";
			for ($i = 1; $i <= 3; $i++) {
				$param_name = "pos" . $i;
				if (isset($_REQUEST[$param_name])) {
					$pomak = $_REQUEST[$param_name] / 1000;
					$program .= "  poz_tcp2[" . ($i - 1) . "]=" . $pomak . "\n";
				}
			}
			for ($i = 4; $i <= 6; $i++) {
				$param_name = "pos" . $i;
				if (isset($_REQUEST[$param_name])) {
					$pomak = $_REQUEST[$param_name] * (M_PI / 180);
					$program .= "  poz_tcp2[" . ($i - 1) . "]=" . $pomak . "\n";
				}
			}
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - TCP pose set');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - TCP pose set\n";
			add_log($novi_tekst);
			$program .= "  movel(poz_tcp2,a=1,v=1,t=0,r=0)\nend\n";
			$message = $program;
			}
		elseif ($val == 402) {
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Robot stopped');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Robot stopped\n";
			add_log($novi_tekst);
			$message1 = "stop\n";
		}
		elseif ($val == 401) {
			echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Program started');</script>";
			$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Program started\n";
			add_log($novi_tekst);
			$message1 = "play\n";
		}
		elseif ($val == 400) {
			if (isset($_REQUEST['naziv_programa'])) {
				$naziv_programa = $_REQUEST['naziv_programa'];
				echo "<script>log_input('" . addslashes($trenutno_vrijeme) . " - Program loaded: " . addslashes($naziv_programa) . "');</script>";
				$novi_tekst = "" . addslashes($trenutno_vrijeme) . " - Program loaded: " . addslashes($naziv_programa) . "\n";
				add_log($novi_tekst);
				$skripta_start_program = "load " . addslashes($naziv_programa) . ".urp\n";
				$message1 = $skripta_start_program;
			}
		} 
			
$minInterval = 1;
$lastSendTime = 0;
if($val != 0 AND $val != 400 AND $val != 401 AND $val != 402) {
	$currentTime = microtime(true);
    if (($currentTime - $lastSendTime) >= $minInterval) {
					if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Couldn't create socket: [$errorcode] $errormsg \n");
					}
					
					if(!socket_connect($sock , '192.168.40.50' , 30002)) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Could not connect: [$errorcode] $errormsg \n");
					}
					
					if(!socket_send($sock , $message , strlen($message), 0)) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Could not send data: [$errorcode] $errormsg \n");
					}
					
					socket_close($sock);
					$lastSendTime = $currentTime;
	}			
}

if($val == 400 OR $val == 401 OR $val == 402) {
	$currentTime = microtime(true);
    if (($currentTime - $lastSendTime) >= $minInterval) {
					if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0))) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Couldn't create socket: [$errorcode] $errormsg \n");
					}
					
					if(!socket_connect($sock , '192.168.40.50' , 29999)) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Could not connect: [$errorcode] $errormsg \n");
					}

					if(!socket_send($sock , $message1 , strlen($message1), 0)) {
						$errorcode = socket_last_error();
						$errormsg = socket_strerror($errorcode);
						die("Could not send data: [$errorcode] $errormsg \n");
					}
					
					if($val == 402){
						$message2 = "popup ROBOT STOPPED!\n";
						if(!socket_send($sock , $message2 , strlen($message2), 0)) {
							$errorcode = socket_last_error();
							$errormsg = socket_strerror($errorcode);
							die("Could not send data: [$errorcode] $errormsg \n");
						}
					}
					
					socket_close($sock);
					$lastSendTime = $currentTime;
	}			
}
?>

</body>
</html>
<?php }else {
	$errorM = "Login First!";
	header("Location: login.php?error=$errorM");
} ?>
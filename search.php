<?php
header('Content-type: text/plain; charset=utf-8');
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

// Create connection

$conn = mysqli_connect("localhost", "root", "453644", "pte_test");

mysqli_set_charset($conn, "utf8");

$sql = "SELECT * FROM quest WHERE q_text LIKE '%". $_POST['name']. "%'";
$result = mysqli_query($conn, $sql);

if(mysqli_num_rows($result)>0){
	while ($row=mysqli_fetch_assoc($result)) {
		echo '<u><em><b>Вопрос</b></em><br></u>';
		$quest = preg_replace('/^ +| +$|( ) +/m', '$1', $row["q_text"]);

		// echo '<em><b>' . $quest . '</b></em><br><br>';
		echo $quest . '<br>';
		if ($row["q_img"]) echo '<img src=img/' . $row["q_img"] . ' alt="фото из вопроса>"';
		echo '<br>';

		echo ($row["ans_2"]) ? '<b><em><u style="background-color: lightgreen;">Несколько ответов:</u></em></b>' . '<br>' : '<b><em><u style="background-color: skyblue;">Один ответ:</u></em></b>' . '<br>';

		echo '- ' . $row["ans_1"];

		if ($row["ans_2"] != null) echo '<hr>- ' . $row["ans_2"];
		if ($row["ans_3"] != null) echo '<hr>- ' . $row["ans_3"];
		if ($row["ans_4"] != null) echo '<hr>- ' . $row["ans_4"];
		if ($row["ans_5"] != null) echo '<hr>- ' . $row["ans_5"] . '<br>';
		echo '<hr style="border: 1px solid palevioletred;">';
	}
}
else{
	echo "<tr><td>0 result's found</td></tr>";
}

?>
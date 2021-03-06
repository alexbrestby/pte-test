<?php
require_once 'config/db.php';
header('Content-type: text/plain; charset=utf-8');
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

$sql = "SELECT * FROM quest WHERE q_text LIKE '%" . $_POST['question'] . "%'";
$sql_lenght = "SELECT COUNT(*) FROM quest";

$result_length = mysqli_query($conn, $sql_lenght);
$row_lenght = mysqli_fetch_array($result_length);

$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0 && (mysqli_num_rows($result) != (int) $row_lenght[0]) && strlen($_POST['question']) >= 10) {

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<u><em><b>Вопрос</b></em></u>';
        $quest = preg_replace('/^ +| +$|( ) +/m', '$1', $row["q_text"]);

        echo "<span class='quest'>" . $quest . "</span><br>";
        if ($row["q_img"]) {
            echo '<img src=assets/img/images/' . $row["q_img"] . ' alt="фото из вопроса">';
        }

        echo '<br>';

        echo ($row["ans_2_text"] || $row["ans_2_img"]) ? '<b><em><u style="background-color: lightgreen; padding: 0 5px 0 5px;">Несколько ответов:</u></em></b>' . '<br>' : '<b><em><u style="background-color: skyblue; padding: 0 5px 0 5px;">Один ответ:</u></em></b>';

        if ($row["ans_1_text"] != null) {
            echo '<p> - ' . $row["ans_1_text"] . '</p>';
        }

        if ($row["ans_1_img"] != null) {
            echo '<img src=assets/img/images/' . $row["ans_1_img"] . ' alt="фото из ответа">';
        }

        if ($row["ans_2_text"] != null) {
            echo '<hr><p> - ' . $row["ans_2_text"] . '</p>';
        }

        if ($row["ans_2_img"] != null) {
            echo '<hr><img src=assets/img/images/' . $row["ans_2_img"] . ' alt="фото из ответа">';
        }

        if ($row["ans_3_text"] != null) {
            echo '<hr><p> - ' . $row["ans_3_text"] . '</p>';
        }

        if ($row["ans_3_img"] != null) {
            echo '<hr><img src=assets/img/images/' . $row["ans_3_img"] . ' alt="фото из ответа">';
        }

        if ($row["ans_4_text"] != null) {
            echo '<hr><p> - ' . $row["ans_4_text"] . '</p>';
        }

        if ($row["ans_4_img"] != null) {
            echo '<hr><img src=assets/img/images/' . $row["ans_4_img"] . ' alt="фото из ответа">';
        }

        if ($row["ans_5_text"] != null) {
            echo '<hr><p> - ' . $row["ans_5_text"] . '</p><br>';
        }

        if ($row["ans_5_img"] != null) {
            echo '<hr><img src=assets/img/images/' . $row["ans_5_img"] . ' alt="фото из ответа">';
        }

        echo '<hr style="border: 1px solid palevioletred;">';
    }

} else {
    echo "<tr><td>Поиск не дал результатов</td></tr>";
}

function debug($param)
{
    echo "<pre>";
    var_dump($param);
    echo "</pre>";
}

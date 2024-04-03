<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>综合页面</title>
    <!-- 其他的 meta、scripts、styles -->
    <style>
        body {
            margin: 0;
            padding: 0;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
        table.calendar {
            border-collapse: collapse;
            margin: auto; /* 让整个表格居中显示 */
        }
        table.calendar th, table.calendar td {
            border: 1px solid #ddd;
            width: 100px;
            height: 100px;
            text-align: left;
            vertical-align: top;
            padding: 5px;
            position: relative; /* 对于定位按钮 */
        }
        .day-number {
            position: absolute;
            top: 5px;
            left: 5px;
        }
        .nav-button {
            position: absolute;
            top: 50%;
            transform: translateY(-50%); /* 垂直居中按钮 */
        }
        .prev-button { left: 0; }
        .next-button { right: 0; }
        .container {
  width: 100%;
  margin: 20px auto;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-bottom: 20px;
}

th, td {
  padding: 8px;
  border: 1px solid #ddd;
}

th {
  background-color: #f2f2f2;
}

tr:nth-child(even) {
  background-color: #f9f9f9;
}

tr:hover {
  background-color: #f5f5f5;
}

.button {
  background-color: #4CAF50;
  border: none;
  color: white;
  padding: 8px 16px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
  margin: 4px 2px;
  cursor: pointer;
}

.add-button {
  background-color: #008CBA;
}

.add-button:hover {
  background-color: #0073a9;
}
    </style>
    <!-- 这里可以添加外部的 CSS 或 JavaScript 文件 -->

<?php
// 设定时区为默认
date_default_timezone_set('Asia/Singapore');

// 检查是否有月份和年份传递，否则使用当前月份和年份
$month = isset($_GET['month']) ? $_GET['month'] : date('m');
$year = isset($_GET['year']) ? $_GET['year'] : date('Y');

// 创建DateTime对象
$dateObject = DateTime::createFromFormat('Y-n', $year . '-' . $month);

// 获取当前月份的天数
$daysInMonth = $dateObject->format('t');

// 获取月份和年份的名称，用于标题
$monthName = $dateObject->format('F');
$yearName = $dateObject->format('Y');

// 计算月份第一天是星期几
$firstDayOfWeek = $dateObject->format('N');

// 生成前一个月和下一个月的数据
$prevMonth = $dateObject->modify('-1 month')->format('m');
$prevYear = $dateObject->format('Y');
$nextMonth = $dateObject->modify('+2 month')->format('m'); // +2 因为之前 -1 了
$nextYear = $dateObject->format('Y');

// 调整回当前月
$dateObject->modify('-1 month');
?>
    
<!-- 表格部分 -->
<div class="container">
    <table>
       <thead>
          <tr>
              <th>Char_Name</th>
              <th>Location</th>
              <th>Head_Name</th>
              <th>Head_Contact_Num</th>
              <th>Choose</th>
      </thead>
      <tbody>
          <?php
          require_once 'db_connect.php';
          $query = "SELECT * FROM charity;";
          $result_0 = $conn->query($query);
          while ($row = $result_0->fetch_assoc()):?>
            <tr>
                <td><?php echo $row['Char_Name'];?></td>
                <td><?php echo $row['Location'];?></td>
                <td><?php echo $row['Head_Name'];?></td>
                <td><?php echo $row['Head_Contact_Num'];?></td>
                <td>
                <input type="checkbox">
                </td>
            </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <button onclick="handleSelection()">操作选中数据</button>
</div>

</head>
<body>

    <table class="calendar">
        <!-- 日历的标题 -->
        <tr>
            <th colspan="7">
                <form method="get" action="" style="display: inline;">
                    <input type="hidden" name="month" value="<?php echo $prevMonth; ?>">
                    <input type="hidden" name="year" value="<?php echo $prevYear; ?>">
                    <button type="submit" class="nav-button prev-button">上个月</button>
                </form>
                <?php echo "$monthName $yearName"; ?>
                <form method="get" action="" style="display: inline;">
                    <input type="hidden" name="month" value="<?php echo $nextMonth; ?>">
                    <input type="hidden" name="year" value="<?php echo $nextYear; ?>">
                    <button type="submit" class="nav-button next-button">下个月</button>
                </form>
            </th>
        </tr>
        <!-- 显示星期 -->
        <tr>
            <th>日</th>
            <th>一</th>
            <th>二</th>
            <th>三</th>
            <th>四</th>
            <th>五</th>
            <th>六</th>
        </tr>
    
    <script>
        // 用于保存选中的日历日期和表格数据的对象
        var selectedData = {
            date: null,
            items: []
        };

        // 日历日期的复选框点击处理
        function selectDate(dayElement, day) {
            // 取消之前选中的日期
            if (selectedData.date) {
                selectedData.date.element.checked = false;
            }
            // 保存新选中的日期
            selectedData.date = {element: dayElement, day: day};
        }

        // 表格条目的复选框点击处理
        function selectItem(itemElement, charName) {
            if (itemElement.checked) {
                // 添加到选中列表
                selectedData.items.push(charName);
            } else {
                // 从选中列表移除
                var index = selectedData.items.indexOf(charName);
                if (index > -1) {
                    selectedData.items.splice(index, 1);
                }
            }
        }

        // 提交选中数据的函数
        function submitSelection() {
            // 检查是否有日期和条目被选中
            if (selectedData.date && selectedData.items.length > 0) {
                console.log("选中日期：", selectedData.date.day);
                console.log("选中条目：", selectedData.items);
                // 这里可以添加代码将选中数据发送到服务器
                // 例如使用 AJAX 请求
            } else {
                alert("请选择日期和至少一个条目。");
            }
        }
    </script>
    
        <!-- 日历的天数部分 -->
        <?php
        echo '<tr>';
        for ($i = 1; $i < $firstDayOfWeek; $i++) { // 输出空白单元格直到第一天
            echo '<td></td>';
        }
        for ($day = 1; $day <= $daysInMonth; $day++, $firstDayOfWeek++) { // 输出每一天
            if ($firstDayOfWeek > 7) {
                $firstDayOfWeek = 1;
                echo '</tr><tr>';
            }
            echo "<td><span class='day-number'>$day</span><input type='checkbox' class='day-checkbox' value='{$day}' style='float: right;' onchange='selectDate(this, $day)'/></td>";
        }
        while ($firstDayOfWeek <= 7) { // 填充最后一行的空白单元格
            echo '<td></td>';
            $firstDayOfWeek++;
        }
        echo '</tr>';
        ?>
    </table>
</body>
</html>



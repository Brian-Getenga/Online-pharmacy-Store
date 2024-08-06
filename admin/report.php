<?php

include '../components/connect.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:admin_login.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
   <link rel="stylesheet" href="../css/admin_style.css">
   <style>
      form{
         width: 100%;
         height: 5rem;
         background-color: blue;
         display: flex;
         justify-content: space-between;
         padding: 1rem;
         align-item: center;
      }
      form input[type=text]{
         width: 150px;
         height: 30px;
         padding: .5rem;
      }
      form  button{
         height: 30px;
         background-color: #32a86d;
         padding: .5rem;
         color: white;
      }
        /* Table Styles */
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table th, table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            font-size: 1.4rem;
        }

        table th {
            background-color: #f2f2f2;

        }

        /* Responsive Table */
        @media screen and (max-width: 600px) {
            table {
                overflow-x: auto;
                display: block;
            }
        }

        /* Hover Effect */
        table tbody tr:hover {
            background-color: #f5f5f5;
        }

        /* Chart Container Style */
        .chart-container {
            position: relative;
            margin: auto;
            height: 400px;
            width: 45%;
        }

        /* Chart Canvas Style */
        .chart-container canvas {
            display: block;
            height: 100%;
            width: 100%;
        }

        .charts {
            display: flex;
            justify-content: space-around;
        }

        .report_dashboard{
         margin-left: 21rem;
         margin-top: 4rem;
         font-size: 1.5rem;
         padding: 1rem;
        }

      </style>
</head>
<body>

<?php include '../components/admin_header.php'; ?>
   
<?php
$host = 'localhost';
$dbname = 'shop_db';
$username = 'root';
$password = '';
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Could not connect to the database $dbname :" . $e->getMessage());
}

// Function to fetch orders grouped by period
function fetchOrdersByPeriod($period, $sort_by, $search_query = null) {
    global $pdo;

    switch ($period) {
        case 'daily':
            $sql = "SELECT DATE(placed_on) as date, name, email, total_products, total_price FROM orders";
            break;
        case 'monthly':
            $sql = "SELECT DATE_FORMAT(placed_on, '%Y-%m') as date, name, email, total_products, total_price FROM orders";
            break;
        case 'yearly':
            $sql = "SELECT YEAR(placed_on) as date, name, email, total_products, total_price FROM orders";
            break;
        default:
            $sql = "SELECT DATE(placed_on) as date, name, email, total_products, total_price FROM orders";
            break;
    }

    if ($search_query) {
        $sql .= " WHERE name LIKE :search_query";
    }

    if ($sort_by == 'name') {
        $sql .= " ORDER BY name";
    } else {
        $sql .= " ORDER BY date";
    }

    $stmt = $pdo->prepare($sql);
    
    if ($search_query) {
        $stmt->bindValue(':search_query', '%' . $search_query . '%');
    }

    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$period = isset($_GET['period']) ? $_GET['period'] : 'daily';
$sort_by = isset($_GET['sort_by']) ? $_GET['sort_by'] : 'date';
$search_query = isset($_GET['search_query']) ? $_GET['search_query'] : null;
$orders = fetchOrdersByPeriod($period, $sort_by, $search_query);

$total_buyers = count($orders);
$total_sales = array_sum(array_column($orders, 'total_price'));
$total_products = array_sum(array_map('intval', array_column($orders, 'total_products')));
?>
<div class="report_dashboard">
    <form method="GET" action="">
      <div class="left">
        <!--<label for="period">Select Period:</label>-->
        <select name="period" id="period">
            <option value="daily" <?php echo $period == 'daily' ? 'selected' : ''; ?>>Daily</option>
            <option value="monthly" <?php echo $period == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
            <option value="yearly" <?php echo $period == 'yearly' ? 'selected' : ''; ?>>Yearly</option>
        </select>
        <!--<label for="sort_by">Sort By:</label>-->
        <select name="sort_by" id="sort_by">
            <option value="date" <?php echo $sort_by == 'date' ? 'selected' : ''; ?>>Date</option>
            <option value="name" <?php echo $sort_by == 'name' ? 'selected' : ''; ?>>Buyer Name</option>
        </select>
        </div>
        <div class="right">
        <input type="text" name="search_query" id="search_query" value="<?php echo htmlspecialchars($search_query); ?>" placeholder="Search Name">
        <button type="submit">Generate</button>
        </div>
    </form>
    
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Name of Buyer</th>
                <th>Email</th>
                <th>Product</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo htmlspecialchars($order['date']); ?></td>
                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                    <td><?php echo htmlspecialchars(preg_replace('/(.{2}).+(.{2}@.+)/', '$1***$2', $order['email'])); ?></td>
                    <td><?php echo htmlspecialchars($order['total_products']); ?></td>
                    <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4">Total Number of Buyers</td>
                <td><?php echo $total_buyers; ?></td>
            </tr>
            <tr>
                <td colspan="4">Total Sales</td>
                <td><?php echo $total_sales; ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="charts">
        <div class="chart-container">
            <canvas id="lineChart"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="pieChart"></canvas>
        </div>
    </div>

            </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var lineCtx = document.getElementById('lineChart').getContext('2d');
        var pieCtx = document.getElementById('pieChart').getContext('2d');

        var labels = <?php echo json_encode(array_column($orders, 'date')); ?>;
        var totalProducts = <?php echo json_encode(array_map('intval', array_column($orders, 'total_products'))); ?>;
        var totalSales = <?php echo json_encode(array_column($orders, 'total_price')); ?>;
        
        // Line Chart
        var lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Total Products Sold',
                        data: totalProducts,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Total Sales',
                        data: totalSales,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderColor: 'rgba(255, 99, 132, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Pie Chart Data Aggregation
        var productAggregation = {};
        labels.forEach((label, index) => {
            if (!productAggregation[label]) {
                productAggregation[label] = 0;
            }
            productAggregation[label] += totalProducts[index];
        });

        var pieLabels = Object.keys(productAggregation);
        var pieData = Object.values(productAggregation);

        // Pie Chart
        var pieChart = new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Products Sold',
                    data: pieData,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Products Sold Comparison'
                    }
                }
            }
        });
    </script>













<?php include '../components/admin-sidebar.php'; ?>

<script src="../js/admin_script.js"></script>
   
</body>
</html>









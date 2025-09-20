<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Project Estimate - <?php echo htmlspecialchars($project->project_name); ?></title>
    <style>
        body { font-family: sans-serif; margin: 20px; }
        h1, h2, h3 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total { font-weight: bold; }
        .header { margin-bottom: 30px; }
        .footer { margin-top: 30px; font-size: 0.8em; color: #666; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Project Estimate</h1>
        <p><strong>Project:</strong> <?php echo htmlspecialchars($project->project_name); ?></p>
        <p><strong>Customer:</strong> <?php echo htmlspecialchars($project->customer_name); ?></p>
        <p><strong>Date:</strong> <?php echo date('Y-m-d'); ?></p>
    </div>

    <h2>System Components</h2>
    <table>
        <thead>
            <tr>
                <th>Component Type</th>
                <th>Brand & Model</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Total Price</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $grandTotal = 0;
            if (!empty($project_components)):
                foreach ($project_components as $item):
                    $totalPrice = $item->quantity * $item->price;
                    $grandTotal += $totalPrice;
            ?>
                <tr>
                    <td><?php echo ucfirst(htmlspecialchars($item->type)); ?></td>
                    <td><?php echo htmlspecialchars($item->brand . ' ' . $item->model); ?></td>
                    <td><?php echo $item->quantity; ?></td>
                    <td>$<?php echo number_format($item->price, 2); ?></td>
                    <td>$<?php echo number_format($totalPrice, 2); ?></td>
                </tr>
            <?php
                endforeach;
            endif;
            ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="total">Grand Total</td>
                <td class="total">$<?php echo number_format($grandTotal, 2); ?></td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        <p>Thank you for your business!</p>
        <p>SolarSaaS</p>
    </div>
</body>
</html>

<table class="table table-bordered table-hover table-condensed dataTable">
    <thead>
        <tr>
            <th class="hide"></th>
            <th width="200">Stok Kodu</th>
            <th>Stok Adı</th>
            <th width="100" title="Maliyet Fiyatı">Maliyet Fiyatı</th>
            <th width="100" title="Satış Fiyatı">Satış Fiyatı</th>
            <th width="80">Adet</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($products as $product): ?>
        <tr>
            <td class="hide"></td>
            <td><a href="<?php echo site_url('product/view/'.$product['id']); ?>"><?php echo $product['code']; ?></a></td>
            <td><?php echo $product['name']; ?></td>
            <td class="text-right"><?php if(item_access('product_cost_price')): ?><?php echo get_money($product['cost_price']); ?><?php else: ?>0.00<?php endif; ?></td>
            <td class="text-right"><?php echo get_money($product['sale_price']); ?></td>
            <td class="text-center"><?php echo get_quantity($product['amount']); ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
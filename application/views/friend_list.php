<tbody>
<tr>
<td>Friend Name</td>
<td>Friend Phone</td>
<td>Friend Address</td>
</tr>
<?php 
foreach($all_friends as $row)
 {
	 ?>
<tr>
<td><?php echo $row->f_name;?></td>
<td><?php echo $row->f_phone;?></td>
<td><?php echo $row->f_address;?></td>
</tr>
<?php }?></tbody>
</table>

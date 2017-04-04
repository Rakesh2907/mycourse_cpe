<table border="1" width="100%" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="2">Course name : <?php echo $course_name;?></td>
  </tr>
  <tr>
    <th>Time</th>
    <th>Notes</th>
  </tr>
  <?php if(count($course_notes) > 0){
	  foreach($course_notes as $key => $mynotes){
  ?>
  <tr>
    <td width="9%"><?php echo date('h:i',strtotime($mynotes['video_seconds']));?></td>
    <td width="91%"><?php echo trim($mynotes['notes']);?></td>
  </tr>
  <?php }
  }?>
</table>

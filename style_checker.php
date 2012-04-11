<?PHP
require("config.php");

define("PAGE_TITLE","Style Checker");

require("header.php");
?>

<style type="text/css">
.grid_header { background: grey;color: #FFFFFF;font-size: 1.6em; padding: 5px; margin: 10px 0; }
</style>

<section id="main">
	<div class="grid_16">
		<div class="grid_header">16 Column Grid</div>
		<h1>Header 1</h1>
		<h2>Header 2</h2>
		<h3>Header 3</h3>
		<h4>Header 4</h4>
		<h5>Header 5</h5>
		<h6>Header 6</h6>
	</div>
	<div class="clear"></div>
	
	<div class="grid_8">
		<div class="grid_header">8 Column Grid</div>
		
		<p>Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample. Paragraph sample.</p>
		
		<ul>
			<li><a href="">Unordered list item w/link</a></li>
			<li><a href="">Unordered list item w/link</a></li>
			<li>Unordered list item</li>
			<li>Unordered list item</li>
		</ul>
		
		<ol>
			<li><a href="">Ordered list item w/link</a></li>
			<li><a href="">Ordered list item w/link</a></li>
			<li>Ordered list item</li>
			<li>Ordered list item</li>
		</ol>
		
		<table width="100%">
		<caption>Table w/caption sample</caption>
		<thead>
			<tr>
				<th>TH Sample Cell</th>
				<th>TH Sample Cell</th>
				<th>TH Sample Cell</th>
				<th>TH Sample Cell</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>A1</td>
				<td>B1</td>
				<td>C1</td>
				<td>D1</td>
			</tr>
			<tr>
				<td>A2</td>
				<td>B2</td>
				<td>C2</td>
				<td>D2</td>
			</tr>
			<tr>
				<td>A3</td>
				<td>B3</td>
				<td>C3</td>
				<td>D3</td>
			</tr>
			<tr>
				<td>A4</td>
				<td>B4</td>
				<td>C4</td>
				<td>D4</td>
			</tr>
		</tbody>
		<tfoot>
			<tr>
				<td>TFOOT cell</td>
				<td>TFOOT cell</td>
				<td>TFOOT cell</td>
				<td>TFOOT cell</td>
			</tr>
		</tfoot>
		</table>
		
		<?PHP echo image::make(LOGO,"Image sample w/alt");?>
	</div>
	<div class="grid_8">
		<div class="grid_header">8 Column Grid</div>
		
		<form method="post" action="">
		
		<label>Form Label:</label> <?PHP echo form::input('text','sample_text','Plain text box');?><br /><br />
		<select name="sample_select1">
			<option value="">Select box sample</option>
			<option value="">Select option</option>
			<option value="">Select option</option>
			<option value="">Select option</option>
			<option value="">Select option</option>
		</select><br /><br />
		<?PHP echo form::input('checkbox','sample_check1',1,'checked');?> Checked checkbox <?PHP echo form::input('checkbox','sample_check2',2);?> Unchecked checkbox<br />
		<?PHP echo form::input('radio','sample_radio1',1,'checked');?> Selected radio button <?PHP echo form::input('radio','sample_radio2',2);?> Empty radio button<br /><br />
		<textarea name="textarea1" id="textarea1" cols="40" rows="5">Textarea sample</textarea>
		
		<br /><br />
		
		<div class="success">Success message</div><br />
		<div class="error">Error message</div><br />
		<div class="notice">Notification message</div><br />
		<div class="inform">Informative message</div><br />
		
		<div class="grid_4 alpha">
			<?PHP echo form::button('button','Default State');?><br />
			<?PHP echo form::button('button','Hover State',"class='button_hover'");?><br />
			<?PHP echo form::button('button','Active State',"class='button_active'");?><br />
			<?PHP echo form::button('button','Busy State',"class='busy'");?><br />
			<?PHP echo form::button('button','Disabled State',"disabled='disabled'");?><br />
		</div>
		<div class="grid_4 omega">
			<?PHP echo form::button('button','Default State',"class='dark'");?><br />
			<?PHP echo form::button('button','Hover State',"class='button_hover dark'");?><br />
			<?PHP echo form::button('button','Active State',"class='button_active dark'");?><br />
			<?PHP echo form::button('button','Busy State',"class='busy dark'");?><br />
			<?PHP echo form::button('button','Disabled State',"disabled='disabled' class='dark'");?><br />
		</div>
		
		</form>
	</div>
	<div class="clear"></div>
	
	<br /><br /><br /><br /><br />
</section>

<script type="text/javascript">
<!--
$(document).ready(function() {
	
});
// -->
</script>

<?PHP 
require("footer.php");
?>
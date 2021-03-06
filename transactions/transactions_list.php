<?php
include ("../templates/header.php");
?>
<div id="dialog-token-points" title="Token points">
	<p>
		<span class="ui-icon ui-icon-circle-check"
			style="float: left; margin: 0 7px 50px 0;"></span>
	
	
	<div id="inner_data_token"></div>
	</p>
</div>
<div id="dialog-prizes-points" title="Prizes points">
	<p>
		<span class="ui-icon ui-icon-circle-check"
			style="float: left; margin: 0 7px 50px 0;"></span>
	
	
	<div id="inner_data_prizes"></div>
	</p>
</div>
<div id="spinner"></div>

<div class="portlet box green">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-globe"></i>Transactions
		</div>
		<!--<div style="float:right;">
        	<a href="member_archive?cmd=list" class="btn default btn-xs blue">Archive</a>
        </div>-->
		<div class="tools">
			<a href="javascript:;" class="reload"></a> <a href="javascript:;"
				class="remove"></a>
		</div>
	</div>
	<div class="portlet-body flip-scroll">
		<table
			class="table table-bordered table-striped table-condensed flip-content">
			<tr>
				<td align="center" valign="top">
					<form name="search_frm" id="search_frm" method="post">
						<table width="60%" border="0" cellpadding="0" cellspacing="0"
							class="bodytext">
							<TR>
								<TD nowrap="nowrap">
					  <?php
    $hash = getTableFieldsName("transactions");
    $hash = array_diff($hash, array(
        "id"
    ));
    ?>
					  Search Key:
					  <select name="field_name" id="field_name" class="textbox">
										<option value="">--Select--</option>
						<?php
    foreach ($hash as $key => $value) {
        ?>
						<option value="<?=$key?>"
											<?php if($_SESSION['field_name']==$key) echo "selected"; ?>><?=str_replace("_"," ",$value)?></option>
						<?php
    }
    ?>
					  </select>
								</TD>
								<TD nowrap="nowrap" align="right"><label for="searchbar"><img
										src="../images/icon_searchbox.png" alt="Search"></label> <input
									type="text" name="field_value" id="field_value"
									value="<?=$_SESSION["field_value"]?>" class="textbox"></TD>
								<td nowrap="nowrap" align="right"><input type="hidden"
									name="cmd" id="cmd" value="search_transactions"> <input
									type="submit" name="btn_submit" id="btn_submit" value="Search"
									class="button" /></td>
							</TR>
						</table>
					</form>
				</td>
			</tr>
			<tr>
				<td><a href="transactions.php?cmd=edit" class="btn btn-primary">Add
						a transaction</a>
					<table
						class="table table-bordered table-striped table-condensed flip-content">
						<tr bgcolor="#ABCAE0">
							<td>Voucher No</td>
							<td>Head</td>
							<td>Account Year</td>
							<td>Account</td>
							<td>Debit</td>
							<td>Credit</td>
							<td>Transaction Date</td>
							<td>Action</td>
						</tr>
		 <?php

if ($_SESSION["search"] == "yes") {
    $whrstr = " AND " . $_SESSION['field_name'] . " LIKE '%" . $_SESSION["field_value"] . "%'";
} else {
    $whrstr = "";
}

$rowsPerPage = 100;
$pageNum = 1;
if (isset($_REQUEST['page'])) {
    $pageNum = $_REQUEST['page'];
}
$offset = ($pageNum - 1) * $rowsPerPage;

$info["table"] = "transactions";
$info["fields"] = array(
    "transactions.*"
);
$info["where"] = "1   $whrstr ORDER BY id DESC  LIMIT $offset, $rowsPerPage";

$arr = $db->select($info);

for ($i = 0; $i < count($arr); $i ++) {

    $rowColor;

    if ($i % 2 == 0) {
        $row = "#C8C8C8";
    } else {
        $row = "#FFFFFF";
    }

    ?>
			<tr bgcolor="<?=$row?>"
							onmouseover=" this.style.background='#ECF5B6'; "
							onmouseout=" this.style.background='<?=$row?>'; ">
							<td><?=$arr[$i]['voucher_no']?></td>
							<td>
					<?php
    unset($info2);
    $info2['table'] = "head";
    $info2['fields'] = array(
        "head_name"
    );
    $info2['where'] = "1 AND id='" . $arr[$i]['head_id'] . "' LIMIT 0,1";
    $res2 = $db->select($info2);
    echo $res2[0]['head_name'];
    ?>
               </td>
							<td>
					<?php
    unset($info2);
    $info2['table'] = "account_year";
    $info2['fields'] = array(
        "*"
    );
    $info2['where'] = "1 AND id='" . $arr[$i]['account_year_id'] . "' LIMIT 0,1";
    $res2 = $db->select($info2);
    echo $res2[0]['name'];
    ?>
               </td>
							<td>
				<?php
    if ($arr[$i]['base'] == 'yes') {
        unset($info2);
        $info2['table'] = "account";
        $info2['fields'] = array(
            "account_name"
        );
        $info2['where'] = "1 AND id='" . $arr[$i]['account_id'] . "' LIMIT 0,1";
        $res2 = $db->select($info2);
        echo $res2[0]['account_name'];
    } else {
        unset($info2);
        $info2['table'] = "account";
        $info2['fields'] = array(
            "account_name"
        );
        $info2['where'] = "1 AND id='" . $arr[$i]['account_id'] . "' LIMIT 0,1";
        $res2 = $db->select($info2);
        echo $res2[0]['account_name'];
    }
    ?>   
               </td>
							<td><?=$arr[$i]['debit']?></td>
							<td><?=$arr[$i]['credit']?></td>
							<td><?=$arr[$i]['transaction_date']?></td>

							<td nowrap>
                  <?php
    if ($i % 2 == 1) {
        ?>
				  <!--<a href="transactions.php?cmd=edit&id=<?=$arr[$i]['id']?>" class="btn default btn-xs purple"><i class="fa fa-edit"></i>Edit</a>-->
								<a
								href="transactions.php?cmd=delete&id=<?=$arr[$i]['id']?>&transaction_no=<?=$arr[$i]['transaction_no']?>"
								class="btn btn-sm red filter-cancel"
								onClick=" return confirm('Are you sure to delete this item ?');"><i
									class="fa fa-times"></i>Delete</a> 
                  <?php
    }
    ?> 
			 </td>

						</tr>
		<?php
}
?>
		
		<tr>
							<td colspan="10" align="center">
			  <?php
    unset($info);

    $info["table"] = "transactions";
    $info["fields"] = array(
        "count(*) as total_rows"
    );
    $info["where"] = "1  $whrstr ORDER BY id DESC";

    $res = $db->select($info);

    $numrows = $res[0]['total_rows'];
    $maxPage = ceil($numrows / $rowsPerPage);
    $self = 'transactions.php?cmd=list';
    $nav = '';

    $start = ceil($pageNum / 5) * 5 - 5 + 1;
    $end = ceil($pageNum / 5) * 5;

    if ($maxPage < $end) {
        $end = $maxPage;
    }

    for ($page = $start; $page <= $end; $page ++) 
    // for($page = 1; $page <= $maxPage; $page++)
    {
        if ($page == $pageNum) {
            $nav .= "<li>$page</li>";
        } else {
            $nav .= "<li><a href=\"$self&&page=$page\" class=\"nav\">$page</a></li>";
        }
    }
    if ($pageNum > 1) {
        $page = $pageNum - 1;
        $prev = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Prev]</a></li>";

        $first = "<li><a href=\"$self&&page=1\" class=\"nav\">[First Page]</a></li>";
    } else {
        $prev = '<li>&nbsp;</li>';
        $first = '<li>&nbsp;</li>';
    }

    if ($pageNum < $maxPage) {
        $page = $pageNum + 1;
        $next = "<li><a href=\"$self&&page=$page\" class=\"nav\">[Next]</a></li>";

        $last = "<li><a href=\"$self&&page=$maxPage\" class=\"nav\">[Last Page]</a></li>";
    } else {
        $next = '<li>&nbsp;</li>';
        $last = '<li>&nbsp;</li>';
    }

    if ($numrows > 1) {
        echo '<ul id="navlist">';
        echo $first . $prev . $nav . $next . $last;
        echo '</ul>';
    }
    ?>     
		   </td>
						</tr>
					</table></td>
			</tr>
		</table>
	</div>
</div>
<?php
include ("../templates/footer.php");
?>  


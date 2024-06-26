<style>
    .form-control{
        padding:10px !important;
    }
</style>

<?php $basicpay = 0 ?>
<?php $basic = 0 ?>
<?php $ob = 0 ?>
<?php $slvlhrs = 0 ?>
<?php $ot = 0 ?>
<?php $offset = 0 ?>
<?php $nightdif = 0 ?>
<?php $late = 0 ?>
<?php $holiday = 0 ?>

<?php $totalearnings = 0 ?>
<?php $totalcontri= 0 ?>
<?php $totaldeduc = 0 ?>
<?php $totalholiday = 0 ?>

<?php $net = 0 ?>
@foreach($payroll as $data)

        <div class="card">
            <div class="card-body">
                Details
                <div class="float-right">
                    <div class="row">

                        

                        <div class="col-3">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="{{ $data->employee_no }}">
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" class="form-control" placeholder="{{ $data->employee_name }}">
                            </div>
                        </div>

                        <div class="col-2">
                            <a class="btn btn-success btn-sm" href="{{ route('payrolllistnav') }}">BACK</a>
                        </div>
                        
                    </div>   
                </div>
            </div>
        </div>    
        
        
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <div class="card-header card-header-text card-header-info">
                    <div class="card-text">
                        <h4 class="card-title">Income / Earnings</h4>
                    </div>
                    </div>

                    <div class="card-body table-responsive">
                        
                        <?php 
                        if($data->basic_pay > 0 && $data->department != "Logistics and Warehouse Department"){
                            $basic =  $data->days - $data->slvl_hrs - $data->holiday_hrs - $data->offdays;
                            $basicpay =  ($data->pay_rate * ($data->days - $data->slvl_hrs - $data->holiday_hrs - $data->offdays));
                        }elseif($data->basic_pay > 0 && $data->department = "Logistics and Warehouse Department"){
                            $basic =  $data->per_trip;
                            $basicpay =  $data->pertrip_amount;
                        }
                        else{
                            $basic =  0;
                            $basicpay =  0;
                        }

                        
                        
                        ?>
                        <form method="get" action="/" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Basic Pay</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pay_rate, 2) }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Days/Trip</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo $basic?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($basicpay, 2);?>" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">SLVL</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pay_rate, 2) }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Days</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->slvl_hrs }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->slvl_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php if($data->holiday_percent == "100"){$totalholiday = $data->pay_rate * 1;}else{$totalholiday = $data->pay_rate * 2;}?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Holiday</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pay_rate, 2) }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">%</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->holiday_percent}}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->holiday_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-2 col-form-label">Off Day</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pay_rate, 2) }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Days</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->offdays }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->offdays_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php $ot = ($data->pay_rate / 8) * 1.25 * 1; ?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">OT Pay</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($ot, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Total Hrs</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->ot_hrs }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->ot_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php $nightdif = ($data->pay_rate / 8) * 0.10 * 8; ?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Night Diff</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($nightdif, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Total Hrs</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->nightdif }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->nightdif_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php $ctlaterate = ($data->pay_rate / 8); ?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">CTLate</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($ctlaterate, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Total Hrs</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->ctlate }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->ctlate_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php $late = ($data->pay_rate / 8) / 60; ?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">Late</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($late, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Total Hrs</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->minutes_late }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->late_amount, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <?php $udt = ($data->pay_rate / 8) / 60; ?>
                            <div class="row">
                                <label class="col-sm-2 col-form-label">UDT</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($udt, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">UDT Hrs</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ $data->udt_hrs * -1 }}" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-2 col-form-label">Amount</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->udt_amount * -1, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>
                        </form>

                            <?php 
                            $totalearnings = ($basicpay + $data->slvl_amount + $data->offdays_amount + $data->ot_amount + $data->holiday_amount + $data->nightdif_amount + $data->ctlate_amount + $data->late_amount + ($data->udt_amount * -1))
                            ?>

                            <div class="row">
                                <label class="col-sm-2 col-form-label" style = "color:green !important;">Total Earnings :</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value = "<?php echo number_format($totalearnings, 2); ?>" style = "background-color:green !important; color: #ffff !important;" readonly>
                                    </div>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-text card-header-danger">
                    <div class="card-text">
                        <h4 class="card-title">Deductions</h4>
                    </div>
                    </div>

                    <div class="card-body table-responsive">

                    <form method="get" action="/" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">ADVANCE</label>
                                <?php if($data->advance == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->advance, 2) }}" readonly>
                                    </div>
                                </div>  
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">Charge</label>
                                <?php if($data->charge == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->charge, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">Uniform</label>
                                <?php if($data->uniform == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->uniform, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">Bond Deposit</label>
                                <?php if($data->bond_deposit == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->bond_deposit, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">meal</label>
                                <?php if($data->meal == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->meal, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">MISC</label>
                                <?php if($data->misc == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->misc, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">MUTUAL CHARGE</label>
                                <?php if($data->mutual_charge == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->mutual_charge, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </form>
                        <?php $totaldeduc = $data->advance + $data->charge + $data->uniform + $data->bond_deposit + $data->meal + $data->misc + $data->mutual_charge ?>
                            <div class="row">
                                <label class="col-sm-4 col-form-label" style = "color:red !important;">Total Deductions :</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($totaldeduc, 2); ?>" style = "background-color:red !important; color: #ffff !important;" readonly>
                                    </div>
                                </div>
                            </div><br><br>

                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-text card-header-warning">
                    <div class="card-text">
                        <h4 class="card-title">Contibutions</h4>
                    </div>
                    </div>

                    <div class="card-body table-responsive">

                        <form method="get" action="/" class="form-horizontal">
                            <div class="row">
                                <label class="col-sm-3 col-form-label">SSS LOAN</label>
                                <?php if($data->sss_loan == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->sss_loan, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">SSS PREM</label>
                                <?php if($data->sss_prem == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->sss_prem, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">PAGIBIG LOAN</label>
                                <?php if($data->pag_ibig_loan == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                    <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pag_ibig_loan, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">PAGIBIG PREM</label>
                                <?php if($data->pag_ibig_prem == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->pag_ibig_prem, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">PhilHealth</label>
                                <?php if($data->philhealth == "")
                                {?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->philhealth, 2) }}" readonly>
                                    </div>
                                </div>
                                <?php } ?>
                            </div>
                        </form>

                        <div class="row">
                            <!-- temporary -->
                                <label class="col-sm-3 col-form-label">Mutual Loan</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->mutual_loan, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <label class="col-sm-3 col-form-label">Mutual Share</label>
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{ number_format($data->mutual_share, 2) }}" readonly>
                                    </div>
                                </div>
                            </div>

                        <?php $totalcontri = $data->sss_loan + $data->sss_prem + $data->pag_ibig_loan + $data->pag_ibig_prem + $data->philhealth + $data->mutual_loan + $data->mutual_share?>
                        <div class="row">
                                <label class="col-sm-4 col-form-label" style = "color:orange !important;">Total Benefits Contibution:</label>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value ="<?php echo number_format($totalcontri, 2); ?>" style = "background-color:orange !important; color: #ffff !important;" readonly>
                                    </div>
                                </div>
                            </div>
                        </br></br>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            

            <div class="col-lg-12 col-md-12">
                <div class="card">
                    <!-- <div class="card-header card-header-text card-header-success">
                    <div class="card-text">
                        <h4 class="card-title">Total Earnings</h4>
                    </div>
                    </div> -->

                    <div class="card-body table-responsive">
                            <div class="row">
                                <label class="col-sm-1 col-form-label">GROSS :</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($totalearnings, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-1 col-form-label">Total Deductions :</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($totaldeduc, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-1 col-form-label">Total Contributions :</label>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($totalcontri, 2); ?>" readonly>
                                    </div>
                                </div>
                                <label class="col-sm-1 col-form-label">TAX :</label>
                                <?php if($data->taxable == "YES" && $data->period == "2nd Period")
                                {
                                    $tax = ($net * 26) * .10
                                ?>
                                
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($tax, 2); ?>" readonly>
                                    </div>
                                </div>
                                <?php }else{?>
                                
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="0" readonly>
                                    </div>
                                </div>
                                <?php }?>
                            </div>

                            <?php 
                                $net = $totalearnings - ($totalcontri + $totaldeduc + $data->ctlate_amount + $data->late_amount + ($data->udt_amount * -1)) 
                            ?>
                            <div class="row">
                                <label class="col-sm-1 col-form-label" style = "color:green !important;">NET :</label>
                                <div class="col-sm-10">
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="<?php echo number_format($net, 2) ?>" style = "background-color:green !important; color: #ffff !important;" readonly>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>

        @endforeach


        
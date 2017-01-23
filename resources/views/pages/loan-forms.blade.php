     <div class="form-group">
                                <label for="purpose">Applied Loan </label>
                                <select class="form-control" id="slctAppliedLoan" name ="product_id" required>
                                    <option value="" min = "0" max="0">-Please Select-</option>   
                                
                                    @foreach($products as $x)
                                        <option value="{{$x->id}}"  min = "{{$x->min}}" max="{{$x->max}}">{{$x->name}}</option>   
                                    @endforeach
                                </select>
                               <input type="hidden" id="client_id" name="client_id" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="purpose">Purpose </label>
                                <select class="form-control" id="slctPurpose" required>
                                    <option value="">-Please Select-</option>
                                    <option value="Business">Business</option>
                                    <option value="Housing Renovation">Housing Renovation</option>
                                    <option value="Education">Education</option>
                                    <option value="Asset Purchase">Asset Purchase</option>
                                    <option value="Others">Others</option>
                             </select>
                            <div class="input-group hidden" id="divGroup"> <input class="form-control "   id="purpose" name="purpose" placeholder="Purpose" aria-describedby="btnBackk"> <span class="input-group-addon" id="btnShowPurposeList">Back</span> </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_amount" id= "loan_validation">Loan Amount </label> 

                                <input type="number" class="form-control" min="2000" max="99000" name ="loan_amount" id ="loan_amount" required >
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="loan_term">Loan Term</label>
                               
                                <select name="loan_term" id="loan_term" class="form-control" required>
                                    <option value="6">6 Months </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 col-lg-2">
                            <div class="form-group">
                                <label for="weeks_to_pay">Weeks To Pay</label>
                               
                                <select name="weeks_to_pay" id="weeks_to_pay" class="form-control" required>
                                    <option value="22">22 Weeks </option>
                                    <option value="24">24 Weeks </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_interest">Interest</label>
                                <input type="number" readonly class="form-control" min="0" name ="loan_interest" id ="loan_interest" required>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4">
                            <div class="form-group">
                                <label for="loan_total">Total Loan</label>
                                <input type="number" class="form-control" min="0" name ="loan_total" id ="loan_total" required >
                            </div>
                        </div>
                
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="weekly_amortization">Weekly Amortization</label>
                                <input type="number"  class="form-control" min="0" name ="weekly_amortization" id ="weekly_amortization" required>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-6">
                            <div class="form-group">
                            
                                <label for="weekly_cbu">Capital Build Up (CBU)</label>
                                <input type="number"  class="form-control" min="0" name ="weekly_cbu" id ="weekly_cbu" required>
                            </div>
                        </div>
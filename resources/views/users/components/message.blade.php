                       <div class="tab-pane fade" id="messages-section" role="tabpanel" aria-labelledby="messages-tab">
                            @if(auth()->user()->hasPermission('Messages'))
                                <h5 class="fw-bold text-dark mb-3">Receipt Message Template</h5>
                                <div class="alert alert-info">
                                    <strong>Available placeholders:</strong>
                                    <code>{name}</code>, <code>{zaka}</code>, <code>{sadaka}</code>,
                                    <code>{makambi}</code>, <code>{shukrani}</code>, <code>{mchango}</code>
                                </div>
                                <form class="form-control" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="receipt_message" class="form-label">Receipt Message</label>
                                        <textarea name="receipt_message" id="receipt_message" class="form-control" rows="6" required
                                            style="color:#000 !important; background-color:#fff !important;">
                                            {{ $receiptMessage ?? "Shukrani {name} kwa mchango wako wa mwezi huu." }}
                                        </textarea>
                                    </div>
                                    <button type="submit" class="btn text-white" style="background-color:#064e3b;">Save Template</button>
                                </form>
                            @endif
                        </div>
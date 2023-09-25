import React, { Component } from 'react'
import SaleContext from '../contexts/SaleContext'

export default class Payment extends Component {

    render() {
        return (
            <>
                <SaleContext.Consumer>
                    {({
                        discountTypes,
                        cashes,
                        discountTypeHandler,
                        discountHandler,
                        paymentTypeHandler,
                        totalPaidHandler,
                        cashIdHandler,
                        //state from mother component
                        subTotal,
                        discountAmount,
                        grandTotal,
                        due,
                        dueStatus,
                        customerPreviousBalance,

                        //from edit
                        sale,
                    }) => (
                        <>
                            <div className="col-md-5">
                                <h5 className="mb-2 fs-5 fw-bold text-muted">
                                    Payment
                                </h5>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label className="mt-1 form-label">
                                            Subtotal
                                        </label>
                                    </div>
                                    <div className="col-9 fw-bold text-end">
                                        BDT.{" "}
                                        {Number.parseFloat(subTotal).toFixed(2)}
                                        <input
                                            type="hidden"
                                            name="subtotal"
                                            defaultValue={subTotal}
                                            min="0"
                                        />
                                    </div>
                                </div>
                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label
                                            htmlFor="previous-balance"
                                            className="mt-1 form-label"
                                        >
                                            Previous balance
                                        </label>
                                    </div>

                                    <div className="col-9">
                                        <div className="input-group mb-2">
                                            <select
                                                name="balance_status"
                                                className={`form-select ${
                                                    customerPreviousBalance >= 0
                                                        ? ""
                                                        : "text-danger"
                                                }`}
                                                // defaultValue={
                                                //     customerPreviousBalance >= 0
                                                //         ? "1"
                                                //         : "0"
                                                // }

                                                // className="form-select"
                                                id="balance-status"
                                                readOnly={true}
                                            >
                                                <option
                                                    value="0"
                                                    selected={
                                                        customerPreviousBalance <
                                                        0
                                                            ? true
                                                            : false
                                                    }
                                                >
                                                    Payable
                                                </option>
                                                <option
                                                    value="1"
                                                    selected={customerPreviousBalance >= 0 ? true : false}
                                                >
                                                    Receivable
                                                </option>
                                            </select>
                                            <input
                                                type="number"
                                                name="previous_balance"
                                                value={Math.abs(
                                                    customerPreviousBalance
                                                )}
                                                className={`form-select fw-bold ${
                                                    customerPreviousBalance >= 0
                                                        ? ""
                                                        : "text-danger"
                                                }`}
                                                id="previous-balance"
                                                placeholder="0.00"
                                                readOnly
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label
                                            htmlFor="discount"
                                            className="mt-1 form-label"
                                        >
                                            Discount
                                        </label>
                                    </div>

                                    <div className="col-9 text-end">
                                        <div className="mb-2 input-group">
                                            <select
                                                name="discount_type"
                                                defaultValue={
                                                    sale.discount_type
                                                }
                                                onChange={discountTypeHandler}
                                                className="form-select"
                                                id="discount_type"
                                            >
                                                {Object.keys(discountTypes).map(
                                                    (discountTypeKey) => (
                                                        <option
                                                            value={
                                                                discountTypeKey
                                                            }
                                                            key={
                                                                discountTypeKey
                                                            }
                                                        >
                                                            {
                                                                discountTypes[
                                                                    discountTypeKey
                                                                ]
                                                            }
                                                        </option>
                                                    )
                                                )}
                                            </select>

                                            <input
                                                type="number"
                                                name="discount"
                                                defaultValue={sale.discount}
                                                onChange={discountHandler}
                                                step="any"
                                                min="0"
                                                className="form-control"
                                                id="discount"
                                                placeholder="0.00"
                                                aria-describedby="discount-addon"
                                            />
                                        </div>
                                        <span className="fw-bold">
                                            BDT.{" "}
                                            {Number.parseFloat(
                                                discountAmount
                                            ).toFixed(2)}
                                        </span>
                                    </div>
                                </div>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label className="mt-1 form-label">
                                            Grand Total
                                        </label>
                                    </div>
                                    <div className="col-9 fw-bold text-end">
                                        BDT.{" "}
                                        {Number.parseFloat(
                                            Math.abs(grandTotal)
                                        ).toFixed(2)}
                                    </div>
                                </div>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label
                                            htmlFor="total-paid"
                                            className="mt-1 form-label required"
                                        >
                                            Total paid
                                        </label>
                                    </div>

                                    <div className="col-9 text-end">
                                        <div className="mb-2 input-group">
                                            <select
                                                name="payment_type"
                                                defaultValue={sale.payment_type}
                                                onChange={paymentTypeHandler}
                                                className="form-select"
                                                id="payment_type"
                                                required
                                            >
                                                <option value="cash">
                                                    Cash
                                                </option>
                                                {/* <option value="bkash">Bkash</option> */}
                                                {/* <option value="rocket" >Rocket</option> */}
                                                {/* <option value="nagad" >Nagad</option> */}
                                                {/* <option value="bank" >Bank</option> */}
                                            </select>

                                            <input
                                                type="number"
                                                name="total_paid"
                                                defaultValue={sale.total_paid}
                                                onChange={totalPaidHandler}
                                                step="any"
                                                min="0"
                                                className="form-control "
                                                id="total_paid"
                                                placeholder="0.00"
                                                aria-describedby="totalPaid-addon"
                                                required
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label
                                            htmlFor="cash-id"
                                            className="mt-1 form-label"
                                        >
                                            &nbsp;
                                        </label>
                                    </div>

                                    <div className="col-9">
                                        <select
                                            name="cash_id"
                                            defaultValue={sale.cash_id}
                                            onChange={cashIdHandler}
                                            className="form-control"
                                            id="cash-id"
                                            required
                                        >
                                            {cashes.map((cash, index) => (
                                                <option
                                                    value={cash.id}
                                                    key={index}
                                                >
                                                    {cash.cash_name}
                                                </option>
                                            ))}
                                        </select>
                                    </div>
                                </div>

                                <div className="mb-3 row">
                                    <div className="col-3">
                                        <label className={`mt-1 form-label`}>
                                            Due{" "}
                                            <span
                                                className={`fw-bold ${
                                                    due >= 0
                                                        ? ""
                                                        : "text-danger"
                                                }`}
                                            >
                                                {dueStatus}
                                            </span>
                                        </label>
                                    </div>
                                    <div className="col-9 fw-bold text-end">
                                        BDT.{" "}
                                        {Number.parseFloat(
                                            Math.abs(due)
                                        ).toFixed(2)}
                                        <input
                                            type="hidden"
                                            name="due"
                                            defaultValue={due}
                                            min="0"
                                        />
                                    </div>
                                </div>
                            </div>
                        </>
                    )}
                </SaleContext.Consumer>
            </>
        );
    }
}

import React, { Component } from 'react'
import Select from "react-select";
import PurchaseContext from '../contexts/PurchaseContext'

export default class SupplierInfo extends Component {
    constructor(props) {
        super(props);

        this.purchase = this.props.purchase,

        this.state = {
            selectedSupplier: "",
        };
    }

    componentDidMount() {

        if (this.purchase) {
            this.setState({
                selectedSupplier: this.purchase.supplier ?? "",
            })

        }

    }

    // Supplier select by onChange event start
    selectedSupplierHandler = (selectedSupplier, forPreviousBalanceHandler) => {
        this.setState({
            selectedSupplier: selectedSupplier,
        });
        forPreviousBalanceHandler(selectedSupplier);
        // console.log(selectedSupplier);
    };
    // Supplier select by onChange event end

    render() {
        const { selectedSupplier } = this.state;
        const { selectedSupplierHandler } = this;
        return (
            <>
                <PurchaseContext.Consumer>
                    {({
                        suppliers,
                        forPreviousBalanceHandler,
                        //from edir
                        purchase,
                        purchaseDate,
                    }) => (
                        <>
                            <div className="col-md-6">
                                <h5 className="mb-2 fs-5 fw-bold text-muted">
                                    Supplier information
                                </h5>
                                <div className="row mb-3">
                                    <div className="col-11">
                                        <label
                                            htmlFor="date"
                                            className="mt-1 form-label required"
                                        >
                                            Date
                                        </label>
                                        <input
                                            type="date"
                                            name="date"
                                            defaultValue={
                                                purchase ? purchaseDate : ""
                                            }
                                            className="form-control"
                                            id="date"
                                            required
                                        />
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <div className="col-11">
                                        <label
                                            htmlFor="supplier-id"
                                            className="mt-1 form-label"
                                        >
                                            Supplier
                                        </label>
                                        <Select
                                            id="supplier-id"
                                            name="supplier_id"
                                            required
                                            getOptionLabel={(supplier) =>
                                                `${supplier.name}`
                                            }
                                            getOptionValue={(supplier) =>
                                                supplier.id
                                            }
                                            options={suppliers}
                                            value={selectedSupplier}
                                            // onChange={selectedSupplierHandler}
                                            onChange={(selectedSupplier) => {
                                                selectedSupplierHandler(
                                                    selectedSupplier,
                                                    forPreviousBalanceHandler
                                                );
                                            }}
                                        />
                                    </div>
                                </div>
                                <div className="row mb-3">
                                    <div className="col-11">
                                        <label
                                            htmlFor="note"
                                            className="mt-1 form-label"
                                        >
                                            Note
                                        </label>
                                        <textarea
                                            name="note"
                                            defaultValue={purchase ? purchase.note:""}
                                            className="form-control"
                                            id="note"
                                            rows="3"
                                            placeholder="Optional"
                                        ></textarea>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}
                </PurchaseContext.Consumer>
            </>
        );
    }
}

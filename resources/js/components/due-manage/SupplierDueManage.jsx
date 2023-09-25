import React, { Component } from 'react';
import { createRoot } from "react-dom/client";
import Select from "react-select";

export default class SupplierDueManage extends Component {
    constructor(props) {
        super(props);

        this.suppliers = JSON.parse(this.props.suppliers);
        this.supplierDue = JSON.parse(this.props.supplierDue);

        this.state = {
            selectedSupplier: "",
            errors: JSON.parse(this.props.errors),
        };
        console.log(this.supplierDue);
    }

    componentDidMount() {
        if (this.supplierDue) {
            this.selectedSupplierHandler(this.supplierDue.supplier);
        }
    }

    // Product select by onChange event start
    selectedSupplierHandler = (selectedSupplier) => {
        this.setState({
            selectedSupplier: selectedSupplier,
        });
        console.log(selectedSupplier);
    };
    // Product select by onChange event end
    render() {
        const { suppliers, selectedSupplierHandler } = this;
        const { selectedSupplier } = this.state;
        return (
            <>
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="category"
                            className="mt-1 form-label required"
                        >
                            Select supplier
                        </label>
                    </div>

                    <div className="col-6">
                        <Select
                            id="supplier-id"
                            name='supplier_id'
                            required
                            getOptionLabel={(supplier) => `${supplier.name}`}
                            getOptionValue={(supplier) => supplier.id}
                            options={suppliers}
                            value={selectedSupplier}
                            // onChange={selectedSupplierHandler}
                            onChange={(selectedSupplier) => {
                                selectedSupplierHandler(selectedSupplier);
                            }}
                        />

                        {/* error */}
                        <small className="text-danger">
                            {Object.keys(this.state.errors).length > 0
                                ? this.state.errors.customer_id[0]
                                : ""}
                        </small>

                        {selectedSupplier && (
                            <div
                                className={`mt-2 p-1 ${
                                    selectedSupplier.balance ? "bg-secondary" : ""
                                }`}
                            >
                                <span className="mx-1 text-light">
                                    {Math.abs(selectedSupplier.balance)}{" "}
                                    {selectedSupplier.balance > 0
                                        ? "Recievable"
                                        : "Payable"}
                                </span>
                            </div>
                        )}
                    </div>
                </div>
            </>
        );
    }
}

// DOM element
if (document.getElementById("get-previous-balance-by-supplier")) {
    // find element by id
    const element = document.getElementById("get-previous-balance-by-supplier");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<SupplierDueManage {...props} />);
}


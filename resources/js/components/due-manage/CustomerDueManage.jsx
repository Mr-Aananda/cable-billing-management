import React, { Component } from 'react';
import { createRoot } from "react-dom/client";
import Select from "react-select";

export default class CustomerDueManage extends Component {
    constructor(props) {
        super(props);

        this.customers = JSON.parse(this.props.customers);
        this.customerDue = JSON.parse(this.props.customerDue);

        this.state = {
            selectedCustomer: "",
            errors: JSON.parse(this.props.errors),
        };
    }
    componentDidMount() {
        if (this.customerDue) {
            this.selectedCustomerHandler(this.customerDue.customer);
        }
    }

    // Product select by onChange event start
    selectedCustomerHandler = (selectedCustomer) => {
        this.setState({
            selectedCustomer: selectedCustomer,
        });
        console.log(selectedCustomer);
    };
    // Product select by onChange event end

    render() {
        const { customers, selectedCustomerHandler } = this;
        const { selectedCustomer } = this.state;
        return (
            <>
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="category"
                            className="mt-1 form-label required"
                        >
                            Select customer
                        </label>
                    </div>

                    <div className="col-6">
                        <Select
                            id="customer-id"
                            name="customer_id"
                            required
                            getOptionLabel={(customer) => `${customer.name}`}
                            getOptionValue={(customer) => customer.id}
                            options={customers}
                            value={selectedCustomer}
                            // onChange={selectedCustomerHandler}
                            onChange={(selectedCustomer) => {
                                selectedCustomerHandler(selectedCustomer);
                            }}
                        />

                        {/* error */}
                        <small className="text-danger">
                            {Object.keys(this.state.errors).length > 0
                                ? this.state.errors.customer_id[0]
                                : ""}
                        </small>

                        {selectedCustomer && (
                            <div
                                className={`mt-2 p-1 ${
                                    selectedCustomer.balance
                                        ? "bg-secondary"
                                        : ""
                                }`}
                            >
                                <span className="mx-1 text-light">
                                    {Math.abs(selectedCustomer.balance)}{" "}
                                    {selectedCustomer.balance >= 0
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
if (document.getElementById("get-previous-balance-by-customer")) {
    // find element by id
    const element = document.getElementById("get-previous-balance-by-customer");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<CustomerDueManage {...props} />);
}


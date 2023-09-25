import React, { Component } from 'react'
import SaleContext from '../contexts/SaleContext';
import Select from "react-select";

export default class CustomerInfo extends Component {
    constructor(props) {
        super(props);

        this.sale = this.props.sale;
        this.state = {
            hideNewCustomer: true,
            hideOldCustomer: false,
            selectedOldCustomer: null,
        };
    }

    componentDidMount() {
        let customerType = this.sale ? "oldCustomer" : "newCustomer";

        this.hideCustomerHandler(customerType);

        this.setState({
            selectedOldCustomer: this.sale ? this.sale.customer : null,
        });
    }

    //Change customer information field by radio button start
    hideCustomerHandler = (value) => {
        this.setState({
            hideNewCustomer: value == "oldCustomer" ? false : true,
            hideOldCustomer: value == "oldCustomer" ? true : false,
        });
    };
    //Change customer information field by radio button end

    selectedOldCustomerHandler = (
        selectedOldCustomer,
        forPreviousBalanceHandler
    ) => {
        this.setState({
            selectedOldCustomer: selectedOldCustomer,
        });
        forPreviousBalanceHandler(selectedOldCustomer);
    };

    render() {
        const { hideNewCustomer, hideOldCustomer, selectedOldCustomer } =
            this.state;
        const { hideCustomerHandler, selectedOldCustomerHandler } = this;
        return (
            <>
                <SaleContext.Consumer>
                    {({
                        customers,
                        areas,
                        sale,
                        forPreviousBalanceHandler,
                    }) => (
                        <>
                            <div className="col-md-7">
                                <h5 className="mb-2 fs-5 fw-bold text-muted">
                                    Customer information
                                </h5>
                                {/* customer radio button start */}
                                <div className="row my-3">
                                    <div className="col-6 d-flex justify-content-start">
                                        <div className="form-check me-4">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="oldOrNewCustomer"
                                                onChange={(e) =>
                                                    hideCustomerHandler(
                                                        e.target.value
                                                    )
                                                }
                                                defaultChecked={
                                                    !selectedOldCustomer
                                                }
                                                id="oldOrNewCustomer1"
                                                value="newCustomer"
                                            />
                                            <label
                                                className="form-check-label fs-6 fw-bold text-muted"
                                                htmlFor="oldOrNewCustomer1"
                                            >
                                                New customer
                                            </label>
                                        </div>
                                        <div className="form-check">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="oldOrNewCustomer"
                                                onChange={(e) =>
                                                    hideCustomerHandler(
                                                        e.target.value
                                                    )
                                                }
                                                defaultChecked={
                                                    selectedOldCustomer
                                                }
                                                value="oldCustomer"
                                                id="oldOrNewCustomer2"
                                            />
                                            <label
                                                className="form-check-label fs-6 fw-bold text-muted"
                                                htmlFor="oldOrNewCustomer2"
                                            >
                                                Old customer
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                {/* customer radio button end */}

                                {hideNewCustomer && (
                                    <>
                                        <div className=" mb-2 row">
                                            <div className="col-6">
                                                <label
                                                    htmlFor="name"
                                                    className="mt-1 form-label required"
                                                >
                                                    Customer name
                                                </label>
                                                <input
                                                    type="text"
                                                    name="name"
                                                    className="form-control "
                                                    id="name"
                                                    placeholder="Character only"
                                                    required
                                                />
                                            </div>

                                            <div className="col-5">
                                                <label
                                                    htmlFor="mobile"
                                                    className="mt-1 form-label required"
                                                >
                                                    Mobile no
                                                </label>
                                                <input
                                                    type="number"
                                                    name="mobile_no"
                                                    className="form-control "
                                                    id="mobile"
                                                    placeholder="01xxxxxxxxx"
                                                    required
                                                />
                                            </div>
                                        </div>
                                        <div className="row mb-2">
                                            <div className="col-11">
                                                <label
                                                    htmlFor="area-id"
                                                    className="mt-1 form-label required"
                                                >
                                                    Select area
                                                </label>
                                                <Select
                                                    name="area_id"
                                                    id="area-id"
                                                    required
                                                    getOptionLabel={(area) =>
                                                        `${area.name}`
                                                    }
                                                    getOptionValue={(area) =>
                                                        area.id
                                                    }
                                                    options={areas}
                                                />
                                            </div>
                                        </div>

                                        <div className="row mb-2">
                                            <div className="col-11">
                                                <label
                                                    htmlFor="address"
                                                    className="mt-1 form-label"
                                                >
                                                    Address
                                                </label>
                                                <textarea
                                                    name="address"
                                                    className="form-control"
                                                    id="address"
                                                    rows="2"
                                                    placeholder="Optional"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </>
                                )}

                                {hideOldCustomer && (
                                    <div className="row mb-2">
                                        <div className="col-11">
                                            <label
                                                htmlFor="customer-id"
                                                className="mt-1 form-label required"
                                            >
                                                Select customer
                                            </label>
                                            <Select
                                                name="customer_id"
                                                id="customer-id"
                                                required
                                                getOptionLabel={(customer) =>
                                                    `${customer.name} - ${customer.mobile_no}`
                                                }
                                                getOptionValue={(customer) =>
                                                    customer.id
                                                }
                                                options={customers}
                                                value={selectedOldCustomer}
                                                // onChange={
                                                //     selectedOldCustomerHandler
                                                // }
                                                onChange={(
                                                    selectedOldCustomer
                                                ) => {
                                                    selectedOldCustomerHandler(
                                                        selectedOldCustomer,
                                                        forPreviousBalanceHandler
                                                    );
                                                }}
                                            />
                                        </div>
                                    </div>
                                )}

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
                                            defaultValue={sale.note}
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
                </SaleContext.Consumer>
            </>
        );
    }
}

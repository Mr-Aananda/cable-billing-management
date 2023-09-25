import React, { Component } from 'react'
import SaleContext from "../contexts/SaleContext";
import Select from "react-select";

export default class Package extends Component {
    constructor(props) {
        super(props);
        this.sale = this.props.sale;
        this.state = {
            startDate: "",
            endDate: "",
            selectedPackage: "",
            showPackage: false,
            totalMonthCount: 1,
        };
    }

    componentDidMount() {
        if (this.sale) {
            this.setState(
                {
                    showPackage: this.sale.package ? true : false,
                    startDate: this.sale ? this.props.activeDate : "",
                    endDate: this.sale ? this.props.expireDate : "",
                    selectedPackage: this.sale ? this.sale.package : "",
                    totalMonthCount: this.state.totalMonthCount,
                },
                () => {
                    this.totalMonthCountHandler();
                    this.packageHandler(
                        this.sale.package, //show package price for edit
                        this.props.packagePriceHandler
                    );
                    console.log(this.state.totalMonthCount);
                }
            );
        }
    }

    componentDidUpdate(prevProps, prevState) {

            if (this.state.totalMonthCount !== prevState.totalMonthCount) {
                this.setState(
                    {
                        totalMonthCount: this.state.totalMonthCount,
                    },
                    () => {
                        this.packageHandler(
                            this.sale
                                ? this.sale.package
                                : this.state.selectedPackage, //show package price for edit
                            this.props.packagePriceHandler
                        );
                    }
                );
                 console.log(this.state.totalMonthCount); // log the updated state value here
             }

    }

    //Choose package using onChange event start
    packageHandler = (selectedPackage, packagePriceHandler) => {
        const { totalMonthCount } = this.state;
        this.setState({
            selectedPackage: selectedPackage,
        });

        // console.log(selectedPackage.id);

        let choosenPackage = this.props.packages.find((data) => {
            if (selectedPackage != null) {
                return data.id === selectedPackage.id;
            }
        });
        // console.log(choosenPackage.price);
        packagePriceHandler(choosenPackage, totalMonthCount);
    };
    //Choose package using onChange event end

    // Show and Hide package field start
    showPackageHandler = () => {
        this.setState({
            showPackage: this.state.showPackage ? false : true,
        });
    };
    // Show and Hide package field end

    startDateHandler = (e) => {
        this.setState({
            startDate: e.target.value,
        });
        // console.log(e.target.value);
    };
    endDateHandler = (e) => {
        this.setState(
            {
                endDate: e.target.value,
            },
            () => {
                this.totalMonthCountHandler();
            }
        );
        // console.log(e.target.value);
    };
    totalMonthCountHandler() {
        const startDate = new Date(this.state.startDate);
        const endDate = new Date(this.state.endDate);
        const monthsDiff =
            (endDate.getFullYear() - startDate.getFullYear()) * 12 +
            (endDate.getMonth() - startDate.getMonth());
        if (startDate < endDate) {
            this.setState({
                totalMonthCount: monthsDiff > 0 ? monthsDiff : 1,
            });
        } else {
            this.setState({
                totalMonthCount: 0,
            });
        }
        // console.log(this.state.totalMonthCount);
    }

    render() {
        const { packageHandler, showPackageHandler } = this;
        const { selectedPackage, showPackage } = this.state;
        return (
            <>
                <SaleContext.Consumer>
                    {({
                        packages,
                        packagePriceHandler,
                        errors,
                        showProductViewHandler,
                        sale,
                        saleDate,
                        expireDate,
                    }) => (
                        <>
                            <div className="mb-3 row">
                                <div className="col-3">
                                    <label
                                        htmlFor="date"
                                        className="mt-1 form-label required"
                                    >
                                        Date
                                    </label>
                                    <input
                                        type="date"
                                        name="date"
                                        defaultValue={saleDate}
                                        onChange={this.startDateHandler}
                                        className="form-control"
                                        id="date"
                                        required
                                    />
                                    {/* error */}
                                    <small className="text-danger">
                                        {Object.keys(errors).length > 0
                                            ? (errors.date ?? [])[0]
                                            : ""}
                                    </small>
                                </div>

                                <div className="col-3">
                                    <label
                                        htmlFor="expire-date"
                                        className="mt-1 form-label"
                                    >
                                        Expire date
                                    </label>
                                    <input
                                        type="date"
                                        name="expire_date"
                                        defaultValue={expireDate}
                                        onChange={this.endDateHandler}
                                        className="form-control"
                                        id="expire-date"
                                    />
                                    {/* error */}
                                    <small className="text-danger">
                                        {Object.keys(errors).length > 0
                                            ? (errors.expire_date ?? [])[0]
                                            : ""}
                                    </small>
                                </div>

                                <div className="col-3">
                                    <label
                                        htmlFor="cable-id"
                                        className="mt-1 form-label required"
                                    >
                                        Cable ID
                                    </label>
                                    <input
                                        type="text"
                                        name="cable_id"
                                        defaultValue={sale.cable_id}
                                        className="form-control"
                                        id="cable-id"
                                        placeholder="xxxxxx"
                                        required
                                    />
                                    {/* error */}
                                    <small className="text-danger">
                                        {Object.keys(errors).length > 0
                                            ? (errors.cable_id ?? [])[0]
                                            : ""}
                                    </small>
                                </div>

                                <div className="col-md-3 d-flex">
                                    {/* <div className="mt-1">&nbsp;</div> */}
                                    <div className="mt-4">
                                        <a
                                            type="button"
                                            className="btn btn-success me-4"
                                            onClick={showPackageHandler}
                                            // onClick={() => {
                                            //     showPackageHandler();
                                            // }}
                                            title="Add package"
                                        >
                                            <i className="bi bi-plus-square me-1"></i>
                                            Add package
                                        </a>
                                    </div>
                                    <div className="mt-4">
                                        <a
                                            type="button"
                                            className="btn btn-success"
                                            onClick={showProductViewHandler}
                                            title="Add package"
                                        >
                                            <i className="bi bi-plus-square me-1"></i>
                                            Add product
                                        </a>
                                    </div>
                                </div>
                            </div>

                            {/* <div className="mb-3 row  w-50">
                                <label className="mb-1 fw-bold text-muted">
                                    Packages
                                </label>
                                {packages.map((data, index) => (
                                    <div className="col-4" key={index}>
                                        <div className="form-check form-check-inline">
                                            <input
                                                className="form-check-input"
                                                type="radio"
                                                name="package_id"
                                                onClick={(e) => {
                                                    packageHandler(
                                                        e.target.value,
                                                        packagePriceHandler
                                                    );
                                                }}
                                                id={`data-${index}`}
                                                value={data.id}
                                            />
                                            <label
                                                className="form-check-label"
                                                htmlFor={`data-${index}`}
                                            >
                                                {data.name}
                                            </label>
                                        </div>
                                    </div>
                                ))}
                            </div> */}

                            {showPackage && (
                                <div className="row mb-3">
                                    <div className="col-8">
                                        <label
                                            htmlFor="package-id"
                                            className="mt-1 form-label"
                                        >
                                            Packages
                                        </label>
                                        <Select
                                            id="package-id"
                                            name="package_id"
                                            getOptionLabel={(packageList) =>
                                                `${packageList.name}`
                                            }
                                            getOptionValue={(packageList) =>
                                                packageList.id
                                            }
                                            options={packages}
                                            value={selectedPackage}
                                            onChange={(selectedPackage) => {
                                                packageHandler(
                                                    selectedPackage,
                                                    packagePriceHandler
                                                );
                                            }}
                                        />
                                    </div>
                                </div>
                            )}
                        </>
                    )}
                </SaleContext.Consumer>
            </>
        );
    }
}

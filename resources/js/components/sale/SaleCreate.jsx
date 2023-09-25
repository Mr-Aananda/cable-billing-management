import React, { Component } from 'react';
import { createRoot } from "react-dom/client";
import SaleContext from '../contexts/SaleContext';
import CustomerInfo from './CustomerInfo';
import Package from './Package';
import Payment from './Payment';
import ProductAdd from './ProductAdd';

export default class SaleCreate extends Component {
    constructor(props) {
        super(props);
        this.packages = JSON.parse(this.props.packages);
        this.products = JSON.parse(this.props.products);
        this.customers = JSON.parse(this.props.customers);
        this.discountTypes = JSON.parse(this.props.discountTypes);
        this.areas = JSON.parse(this.props.areas);
        this.cashes = JSON.parse(this.props.cashes);

        //from database for edit/update

        this.sale = JSON.parse(this.props.sale);

        this.state = {
            customerPreviousBalance: 0,
            packagePrice: 0,
            cartItemsPrice: 0,
            subTotal: 0,
            discount: 0,
            discountAmount: 0,
            discountType: "flat",
            grandTotal: 0,
            paymentType: "",
            cashId: "",
            totalPaid: 0,
            due: 0,
            dueStatus: "",

            showProductAddAndCart: false,

            errors: JSON.parse(this.props.errors),

            // for edit
            saleDate: this.props.date,
            activeDate: this.props.activeDate,
            expireDate: this.props.expireDate,
        };

        // console.log(this.props.expireDate);
    }

    componentDidMount() {
        if (this.sale) {
            let products = this.sale.product_sales;
            this.setState({
                showProductAddAndCart: products != "" ? true : false,
            });

            this.setState(
                {
                    subTotal: this.sale.subtotal,
                    customerPreviousBalance: this.sale.previous_balance,
                    grandTotal: this.sale.grand_total,
                    discount: this.sale.discount,
                    totalPaid: this.sale.total_paid,
                    discountType: this.sale.discount_type,
                },
                () => {
                    this.getDiscountAmountHandler();
                }
            );
        }
    }

    //Total package price from package component start
    packagePriceHandler = (choosenPackage, totalMonthCount) => {
        console.log(totalMonthCount);
        let packagePrice = choosenPackage ? choosenPackage.price : 0;
        const totalPackagePrice = packagePrice * parseInt(totalMonthCount ?? 0);
        this.setState(
            {
                packagePrice: parseFloat(totalPackagePrice),
            },
            () => {
                this.calculateTotal();
            }
        );
    };
    //Total package price from package component end

    //Total product price from product add and cart component start
    totalProductPriceHandler = (cartItems) => {
        // const cartItemsPrice = cartItems.reduce(
        //     (a, c) => a + c.sale_price * c.quantity,
        //     0
        // );

        const cartItemsPrice = cartItems.reduce(
            (a, c) => a + (c?.salePrice || c.sale_price) * c.quantity,
            0
        );

        this.setState(
            {
                cartItemsPrice: cartItemsPrice,
            },
            () => {
                this.calculateTotal();
            }
        );
    };
    //Total product price from product add and cart component end

    //Total calcultion for package and product cart
    calculateTotal = () => {
        // TODO get current package price
        const packagePrice = this.state.packagePrice; // package price

        // TODO get current cart items price

        const cartItemsPrice = this.state.cartItemsPrice; // collect total of cart items

        const total = packagePrice + cartItemsPrice;

        // todo finally set total on state
        this.setState(
            {
                subTotal: total,
                grandTotal: total,
                due: total,
            },
            () => {
                if (this.state.due >= 0) {
                    this.setState({ dueStatus: "(Receivable)" });
                } else {
                    this.setState({ dueStatus: "(payable)" });
                }

                this.calculateWithCustomerPreviousBalance();
                this.getDiscountAmountHandler();
            }
        );

        // TODO take nessessary action for due or change value & discount amount
        //For edit option start
        // Show or calculate result for discount
        // this.setState(
        //     {
        //         discount: this.sale.discount,
        //     },
        //     this.getDiscountAmountHandler
        // );

        // Show or calculate result for paid
        // this.setState(
        //     {
        //         totalPaid: this.props.editTotalPaid,
        //     },
        //     this.getTotalDiscountHandler
        // );

        //For edit option end
    };

    //customer previos balance start
    forPreviousBalanceHandler = (selectCustomer) => {
        const customerPreviousBalance = selectCustomer
            ? selectCustomer.balance
            : 0;
        this.setState(
            {
                customerPreviousBalance: customerPreviousBalance,
            },
            () => {
                this.calculateWithCustomerPreviousBalance();
            }
        );
        // console.log(selectCustomer.balance);
    };
    //customer previos balance end

    calculateWithCustomerPreviousBalance = () => {
        const customerPreviousBalance = this.state.customerPreviousBalance;
        const cartItemsPrice = this.state.cartItemsPrice;
        const packagePrice = this.state.packagePrice;

        let total =
            Number(cartItemsPrice) +
            Number(packagePrice) -
            -1 * customerPreviousBalance;

        this.setState(
            {
                grandTotal: total,
                due: total,
            },
            () => {
                if (this.state.due >= 0) {
                    this.setState({ dueStatus: "(Receivable)" });
                } else {
                    this.setState({ dueStatus: "(payable)" });
                }
            }
        );
    };

    //Payment calculation for payment component start
    discountTypeHandler = (e) => {
        this.setState(
            {
                discountType: e.target.value,
            },
            this.getDiscountAmountHandler
        );
    };

    discountHandler = (e) => {
        this.setState(
            {
                discount: e.target.value,
            },
            this.getDiscountAmountHandler
        );
    };

    getDiscountAmountHandler = () => {
        let { discount, discountType, subTotal } = this.state;

        let getDiscount = discount || 0;

        if (discountType === "percentage") {
            getDiscount = (subTotal * getDiscount) / 100;
        }

        this.setState(
            {
                discountAmount: getDiscount,
            },
            this.getGrandTotalHandler
        );
    };

    getGrandTotalHandler = () => {
        let { subTotal, discountAmount, customerPreviousBalance } = this.state;
        this.setState(
            {
                grandTotal:
                    Number(subTotal) -
                    Number(-1 * customerPreviousBalance) -
                    Number(discountAmount),
            },
            this.getTotalDiscountHandler
        );
    };

    paymentTypeHandler = (e) => {
        this.setState({
            paymentType: e.target.value,
        });
    };

    cashIdHandler = (e) => {
        this.setState({
            cashId: e.target.value,
        });
    };

    totalPaidHandler = (e) => {
        this.setState(
            {
                totalPaid: e.target.value,
            },
            this.getTotalDiscountHandler
        );
    };

    getTotalDiscountHandler = () => {
        let { grandTotal, totalPaid } = this.state;
        this.setState(
            {
                due: grandTotal - totalPaid || 0,
            },
            () => {
                if (this.state.due >= 0) {
                    this.setState({ dueStatus: "(Receivable)" });
                } else {
                    this.setState({ dueStatus: "(payable)" });
                }
            }
        );
    };

    //Patment calculation for payment component end

    // Show or hide product field start
    showProductViewHandler = () => {
        this.setState({
            showProductAddAndCart: this.state.showProductAddAndCart
                ? false
                : true,
        });
    };
    // Show or hide product field end

    render() {
        const {
            packages,
            products,
            customers,
            discountTypes,
            areas,
            cashes,
            //Functions
            packagePriceHandler,
            totalProductPriceHandler,
            discountTypeHandler,
            discountHandler,
            totalPaidHandler,
            paymentTypeHandler,
            cashIdHandler,
            showProductViewHandler,
            forPreviousBalanceHandler,

            sale,
        } = this;
        const {
            subTotal,
            discountAmount,
            grandTotal,
            due,
            dueStatus,
            errors,
            showProductAddAndCart,
            customerPreviousBalance,

            saleDate,
            activeDate,
            expireDate,
        } = this.state;

        return (
            <>
                <SaleContext.Provider
                    value={{
                        //From Controller
                        packages,
                        products,
                        customers,
                        discountTypes,
                        areas,
                        cashes,

                        //From State
                        subTotal,
                        discountAmount,
                        grandTotal,
                        due,
                        dueStatus,
                        errors,
                        showProductAddAndCart,
                        customerPreviousBalance,

                        //From functions
                        packagePriceHandler,
                        totalProductPriceHandler,
                        showProductViewHandler,
                        //for payment component
                        discountTypeHandler,
                        discountHandler,
                        paymentTypeHandler,
                        totalPaidHandler,
                        cashIdHandler,

                        //For customer component
                        forPreviousBalanceHandler,

                        //from edit
                        sale,
                        saleDate,
                        activeDate,
                        expireDate,
                    }}
                >
                    {/* Package component */}
                    <Package
                        packages={packages}
                        sale={sale}
                        activeDate={activeDate}
                        expireDate={expireDate}
                        packagePriceHandler={packagePriceHandler}
                    />

                    {/* Product add component */}
                    <ProductAdd
                        products={products}
                        sale={sale}
                        totalProductPriceHandler={totalProductPriceHandler}
                    />

                    <div className="row">
                        {/* Customer information component*/}
                        <CustomerInfo sale={sale} />

                        {/* Payment component  */}
                        <Payment />
                    </div>
                </SaleContext.Provider>
            </>
        );
    }
}

// DOM element
if (document.getElementById("sale-create")) {
    // find element by id
    const element = document.getElementById("sale-create");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<SaleCreate {...props} />);
}


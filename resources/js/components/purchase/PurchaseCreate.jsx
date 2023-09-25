import React, { Component } from 'react';
import { createRoot } from "react-dom/client";
import PurchaseContext from '../contexts/PurchaseContext';
import Payment from './Payment';
import PurchaseProduct from './PurchaseProduct';
import SupplierInfo from './SupplierInfo';

export default class PurchaseCreate extends Component {
    constructor(props) {
        super(props);
        this.suppliers = JSON.parse(this.props.suppliers);
        this.products = JSON.parse(this.props.products);
        this.discountTypes = JSON.parse(this.props.discountTypes);
        this.cashes = JSON.parse(this.props.cashes);

        //from database for edit/update
        this.purchase = JSON.parse(this.props.purchase);

        this.state = {
            supplierPreviousBalance: 0,
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
            errors: JSON.parse(this.props.errors),

            // for edit
            purchaseDate: this.props.date,
        };

        console.log(this.purchase);
        // console.log(this.purchase.previous_balance);
    }

    componentDidMount() {
        if (this.purchase) {

            this.setState(
                {
                    subTotal: this.purchase.subtotal,
                    supplierPreviousBalance: this.purchase.previous_balance,
                    grandTotal: this.purchase.grand_total,
                    discount: this.purchase.discount,
                    totalPaid: this.purchase.total_paid,
                    discountType: this.purchase.discount_type,
                },
                () => {
                    this.getDiscountAmountHandler();
                }
            );

            // console.log(this.state.supplierPreviousBalance);

        }
    }

    //Total product price from product add and cart component start
    totalProductPriceHandler = (cartItems) => {
        // For create
        // const cartItemsPrice = cartItems.reduce(
        //     (a, c) => a + c.purchasePrice * c.quantity,
        //     0
        // );

        //after edit
        const cartItemsPrice = cartItems.reduce(
            (a, c) => a + (c?.purchasePrice || c.purchase_price) * c.quantity,
            0
        );

        // console.log(cartItemsPrice);
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

    //Total calcultion for product cart start
    calculateTotal = () => {
        // TODO get current cart items price

        const cartItemsPrice = this.state.cartItemsPrice; // collect total of cart items

        // todo finally set total on state
        this.setState(
            {
                subTotal: cartItemsPrice,
                grandTotal: cartItemsPrice,
                due: cartItemsPrice,
            },
            () => {
                this.calculateWithSupplierPreviousBalance();
                this.getDiscountAmountHandler();
            }
        );
    };
    //Total calcultion for product cart end

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
        let { subTotal, discountAmount, supplierPreviousBalance } = this.state;

        this.setState(
            {
                grandTotal:
                    Number(subTotal) +
                    Number(-1 * supplierPreviousBalance) -
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
                    this.setState({ dueStatus: "(Payable)" });
                } else {
                    this.setState({ dueStatus: "(Recivable)" });
                }
            }
        );
    };
    //Patment calculation for payment component end

    //Supplier previos balance start
    forPreviousBalanceHandler = (selectSupplier) => {
        const supplierPreviousBalance = selectSupplier
            ? selectSupplier.balance
            : 0;
        this.setState(
            {
                supplierPreviousBalance: supplierPreviousBalance,
            },
            () => {
                this.calculateWithSupplierPreviousBalance();
            }
        );
        // console.log(selectSupplier.balance);
    };
    //Supplier previos balance start

    calculateWithSupplierPreviousBalance = () => {
        // console.log(this.state.supplierPreviousBalance);
        const supplierPreviousBalance = this.state.supplierPreviousBalance;
        const cartItemsPrice = this.state.cartItemsPrice;

        let total = Number(cartItemsPrice) + -1 * supplierPreviousBalance;

        // let total
        // if (supplierPreviousBalance < 0) {
        //     total =
        //         Number(Number(cartItemsPrice) + Math.abs(supplierPreviousBalance));
        // }
        // else {
        //      total = Math.abs(
        //          Number(cartItemsPrice) - Number(supplierPreviousBalance)
        //      );
        // }

        this.setState(
            {
                grandTotal: total,
                due: total,
            },
            () => {
                if (this.state.due >= 0) {
                    this.setState({ dueStatus: "(payable)" });
                } else {
                    this.setState({ dueStatus: "(Receivable)" });
                }
            }
        );
    };

    render() {
        const {
            suppliers,
            products,
            discountTypes,
            cashes,

            //Function
            forPreviousBalanceHandler,
            totalProductPriceHandler,
            //for payment component
            discountTypeHandler,
            discountHandler,
            paymentTypeHandler,
            totalPaidHandler,
            cashIdHandler,

            //from edit
            purchase,
        } = this;

        const {
            supplierPreviousBalance,
            subTotal,
            discountAmount,
            grandTotal,
            due,
            dueStatus,

            //from edit
            purchaseDate,
        } = this.state;
        return (
            <>
                <PurchaseContext.Provider
                    value={{
                        suppliers,
                        products,
                        discountTypes,
                        cashes,

                        //Function
                        forPreviousBalanceHandler,
                        totalProductPriceHandler,
                        //for payment component
                        discountTypeHandler,
                        discountHandler,
                        paymentTypeHandler,
                        totalPaidHandler,
                        cashIdHandler,

                        //state
                        supplierPreviousBalance,
                        subTotal,
                        discountAmount,
                        grandTotal,
                        due,
                        dueStatus,

                        //from edit
                        purchase,
                        purchaseDate,
                    }}
                >
                    <PurchaseProduct
                        purchase={purchase}
                        totalProductPriceHandler={totalProductPriceHandler}
                    />

                    <div className="row">
                        <SupplierInfo purchase={purchase} />
                        <Payment />
                    </div>
                </PurchaseContext.Provider>
            </>
        );
    }
}

// DOM element
if (document.getElementById("purchase-create")) {
    // find element by id
    const element = document.getElementById("purchase-create");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<PurchaseCreate {...props} />);
}


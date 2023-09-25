import React, { Component } from 'react'
import Select from "react-select";
import PurchaseCart from "./PurchaseCart";
import PurchaseContext from "../contexts/PurchaseContext";

export default class PurchaseProduct extends Component {
    constructor(props) {
        super(props);

        this.purchase = this.props.purchase,

        this.state = {
            selectedProducts: "",
            AvailableStocks:0,
            purchasePrice: 0,
            quantity: 1,
            quantityType: "pcs",
            cartItems: [],
        };
    }

    componentDidMount() {
        if (this.purchase) {
            const products = this.purchase.product_purchases.map((data) => data);

            // console.log(products);

            this.setState(
                {
                    cartItems: products,
                },

                this.props.totalProductPriceHandler(products)
            );

            // console.log(products);
        }


    }

    // Product select by onChange event start
    selectedProductHandler = (selectedProducts) => {
        this.setState({
            selectedProducts: selectedProducts,
            purchasePrice: selectedProducts.purchase_price,
            AvailableStocks: selectedProducts.total_product_quantity,
        });
        console.log(selectedProducts);
    };
    // Product select by onChange event end

    productPurchasePrinceHandler = (e) => {
        this.setState({
            purchasePrice: e.target.value,
        });
        // console.log(this.state.purchasePrice);
    };

    // Onchange event for quantity select start
    productQuantityHandler = (e) => {
        this.setState({
            quantity: e.target.value,
        });
    };
    //Onchange event for quantity select end

    //Onchange event for quantity type select start
    quantityTypeHandler = (e) => {
        this.setState({
            quantityType: e.target.value,
        });
    };
    //Onchange event for quantity type select end

    //Add multiple product to the cart start
    addProductToCard = (product, totalProductPriceHandler) => {
        const { cartItems, purchasePrice, quantity, quantityType } = this.state;
        // console.log("cart item", cartItems);
        const exist = cartItems.find((item) => {
            if (item.product_id) {
                return item.product_id === product.id;
            }

            return item.id === product.id;
        });

        // if product is already exists
        if (exist != undefined) {
            // console.log(exist);
            alert("Product already added.");
            return;
        }

        let item = cartItems.map((item) =>
            item.id === product.id
                ? { ...exist, purchasePrice, quantity, quantityType }
                : item
        );

        if (exist) {
            this.setState(
                {
                    cartItems: item,
                }
                // () => {
                //     this.totalProductPrice(totalProductPriceHandler)       //Call back function
                // }
            );
        } else {
            item = [
                ...cartItems,
                { ...product, purchasePrice, quantity, quantityType },
            ];

            this.setState(
                {
                    cartItems: item,
                }
                // () => {
                //     this.totalProductPrice(totalProductPriceHandler);    //Call back function
                // }
            );
            //   console.log(this.state.cartItems);
        }

        // For add item input clear
        this.setState({
            selectedProducts: "",
            purchasePrice: 0,
            quantity: 1,
            quantityType: "pcs",
        });

        totalProductPriceHandler(item);
    };
    //Add multiple product to the cart end

    //Remove from cart start
    deleteItem = (index, totalProductPriceHandler) => {
        const dataDelete = [...this.state.cartItems];
        dataDelete.splice(index, 1);

        this.setState({
            cartItems: dataDelete,
        });
        totalProductPriceHandler(dataDelete);
    };
    //Remove from cart end

    render() {
        const {
            selectedProducts,
            quantity,
            quantityType,
            cartItems,
            purchasePrice,
            AvailableStocks,
        } = this.state;
        const {
            selectedProductHandler,
            productPurchasePrinceHandler,
            productQuantityHandler,
            quantityTypeHandler,
            addProductToCard,
            deleteItem,
        } = this;
        return (
            <>
                <PurchaseContext.Consumer>
                    {({
                        products,
                        totalProductPriceHandler,

                        //from edit
                        purchase,
                    }) => (
                        <>
                            <div className="row mb-3">
                                <div className="col-4">
                                    <label
                                        htmlFor="product-id"
                                        className="mt-1 form-label required"
                                    >
                                        Product
                                    </label>
                                    <Select
                                        id="product-id"
                                        required
                                        getOptionLabel={(product) =>
                                            `${product.name}`
                                        }
                                        getOptionValue={(product) => product.id}
                                        options={products}
                                        value={selectedProducts}
                                        // onChange={selectedProductHandler}
                                        onChange={(selectedProducts) => {
                                            selectedProductHandler(
                                                selectedProducts
                                            );
                                        }}
                                    />
                                    {selectedProducts && (
                                        <div className="bg-secondary mt-1 p-1">
                                            <small className="text-light fs-6">
                                                Stock available :{" "}
                                                <span className="text-light fw-bold">
                                                    {" "}
                                                    {AvailableStocks}
                                                </span>
                                            </small>
                                        </div>
                                    )}
                                </div>

                                <div className="col-2">
                                    <label
                                        htmlFor="purchase-price"
                                        className="mt-1 form-label required"
                                    >
                                        Purchase price
                                    </label>
                                    <input
                                        type="number"
                                        className="form-control"
                                        id="purchase-price"
                                        value={purchasePrice}
                                        onChange={productPurchasePrinceHandler}
                                        placeholder="0.00"
                                        min="0"
                                        required
                                    />
                                </div>

                                <div className="col-3">
                                    <label
                                        htmlFor="quantity"
                                        className="mt-1 form-label required"
                                    >
                                        Quantity
                                    </label>
                                    <div className="mb-2 input-group">
                                        <div className="col-7">
                                            <input
                                                type="number"
                                                className="form-control"
                                                id="quantity"
                                                value={quantity}
                                                onChange={
                                                    productQuantityHandler
                                                }
                                                placeholder="0"
                                                min="0"
                                                required
                                            />
                                        </div>

                                        <div className="col-4">
                                            <select
                                                className="form-select"
                                                id="qty_type"
                                                value={quantityType}
                                                onChange={quantityTypeHandler}
                                                required
                                            >
                                                <option value="pcs">pcs</option>
                                                <option value="yard">
                                                    yard
                                                </option>
                                                <option value="meter">
                                                    meter
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div className="col-3">
                                    <div className="mt-1">&nbsp;</div>
                                    <button
                                        type="button"
                                        className={`btn btn-success ${
                                            selectedProducts == ""
                                                ? "disabled"
                                                : ""
                                        }`}
                                        onClick={() =>
                                            addProductToCard(
                                                selectedProducts,
                                                totalProductPriceHandler
                                            )
                                        }
                                        title="Add product"
                                    >
                                        <span>
                                            <i className="bi bi-cart2"></i>
                                            <span> Add to cart </span>
                                        </span>
                                    </button>
                                </div>
                            </div>

                            {/* Add to cart component */}
                            <PurchaseCart
                                cartItems={cartItems}
                                deleteItem={deleteItem}
                                totalProductPriceHandler={
                                    totalProductPriceHandler
                                }
                                purchase={purchase}
                            />
                        </>
                    )}
                </PurchaseContext.Consumer>
            </>
        );
    }
}

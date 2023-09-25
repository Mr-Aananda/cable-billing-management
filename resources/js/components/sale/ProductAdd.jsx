import React, { Component } from 'react'
import SaleContext from '../contexts/SaleContext';
import ProductCart from './ProductCart';
import Select from "react-select";


export default class ProductAdd extends Component {
    constructor(props) {
        super(props);
        this.sale = this.props.sale;

        this.state = {
            selectedProducts: "",
            selectedStock: "",
            salePrice: 0,
            oldPurchasePrice: 0,
            selectedStockQuantity: 0,
            quantity: 1,
            quantityType: "pcs",
            cartItems: [],
            updatingIndex: null,
        };
    }

    componentDidMount() {
        if (this.sale) {
            const products = this.sale.product_sales.map((data) => data);

            // console.log(products);

            this.setState(
                {
                    cartItems: products,
                },

                this.props.totalProductPriceHandler(products)
            );
        }
    }

    // Product select by onChange event start
    selectedProductHandler = (selectedProducts) => {
        this.setState({
            selectedProducts: selectedProducts,
            salePrice: selectedProducts.sale_price,
        });

        console.log(selectedProducts.stock);
    };
    // Product select by onChange event end

    //Get Product sale price by onchange start
    productSalePriceHandler = (e) => {
        this.setState({
            salePrice: e.target.value,
        });
        // console.log(this.state.purchasePrice);
    };
    //Get Product sale price by onchange start

    //Get old purchase prices by onchange start
    productOldPurchasePriceHandler = (selectedStock) => {
        this.setState(
            {
                selectedStock: selectedStock,
            },
            () => {
                this.getPurchasePriceAndQuantitybyStockId();
            }
        );
        // console.log(selectedStock);
    };
    //Get old purchase prices by onchange start

    //Get old purchase stock quantity by by selected stock start
    getPurchasePriceAndQuantitybyStockId = () => {
        const { selectedStock } = this.state;

        this.setState({
            oldPurchasePrice: selectedStock.purchase_price,
            selectedStockQuantity: selectedStock.quantity,
        });

        // console.log(selectedStock.purchase_price);
        // console.log(selectedStock.quantity);
    };
    //Get old purchase stock quantity by by selected stock end

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
        const {
            cartItems,
            salePrice,
            oldPurchasePrice,
            quantity,
            quantityType,
        } = this.state;
        // console.log('cart item', cartItems);
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
                ? {
                      ...exist,
                      salePrice,
                      oldPurchasePrice,
                      quantity,
                      quantityType,
                  }
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
                {
                    ...product,
                    salePrice,
                    oldPurchasePrice,
                    quantity,
                    quantityType,
                },
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
            salePrice: 0,
            selectedStock: "",
            quantity: 1,
            quantityType: "pcs",
        });

        totalProductPriceHandler(item);
    };

    //Add multiple product to the cart end

    // this function for call back function

    // totalProductPrice = (fn) => {
    //     const itemsPrice = this.state.cartItems.reduce(
    //         (a, c) => a + c.sale_price * c.quantity,
    //         0
    //     );
    //     fn(itemsPrice);

    //     console.log(itemsPrice);
    // };

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
            salePrice,
            selectedStock,
            selectedStockQuantity,
            quantity,
            quantityType,
            cartItems,
        } = this.state;
        const {
            selectedProductHandler,
            productSalePriceHandler,
            productQuantityHandler,
            quantityTypeHandler,
            addProductToCard,
            deleteItem,
            productOldPurchasePriceHandler,
        } = this;

        return (
            <>
                <SaleContext.Consumer>
                    {({
                        products,
                        totalProductPriceHandler,
                        showProductAddAndCart,
                    }) => (
                        <>
                            {showProductAddAndCart && (
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
                                                getOptionValue={(product) =>
                                                    product.id
                                                }
                                                options={products}
                                                value={selectedProducts}
                                                // onChange={
                                                //     selectedProductHandler
                                                // }
                                                onChange={(
                                                    selectedProducts
                                                ) => {
                                                    selectedProductHandler(
                                                        selectedProducts
                                                    );
                                                }}
                                            />

                                            {selectedStock && (
                                                <div className="bg-secondary mt-1 p-1">
                                                    <small className="text-light fs-6">
                                                        Stock available :{" "}
                                                        <span className="text-light fw-bold">
                                                            {" "}
                                                            {
                                                                selectedStockQuantity
                                                            }
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
                                                Choose purchase price
                                            </label>

                                            <Select
                                                id="product-id"
                                                required
                                                getOptionLabel={(stock) =>
                                                    `${stock.purchase_price} BDT`
                                                }
                                                getOptionValue={(stock) =>
                                                    stock.id
                                                }
                                                options={selectedProducts.stock}
                                                value={selectedStock}
                                                // onChange={
                                                //     selectedProductHandler
                                                // }
                                                onChange={(selectedStock) => {
                                                    productOldPurchasePriceHandler(
                                                        selectedStock
                                                    );
                                                }}
                                            />
                                        </div>

                                        <div className="col-2">
                                            <label
                                                htmlFor="sale-price"
                                                className="mt-1 form-label required"
                                            >
                                                Sale price
                                            </label>
                                            <input
                                                type="number"
                                                className="form-control"
                                                id="sale-price"
                                                value={salePrice}
                                                onChange={
                                                    productSalePriceHandler
                                                }
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
                                                <input
                                                    type="number"
                                                    className="form-control"
                                                    id="quantity"
                                                    placeholder="0"
                                                    value={quantity}
                                                    onChange={
                                                        productQuantityHandler
                                                    }
                                                    min="0"
                                                    required
                                                />

                                                <div className="col-4">
                                                    <select
                                                        className="form-select"
                                                        id="qty_type"
                                                        value={quantityType}
                                                        onChange={
                                                            quantityTypeHandler
                                                        }
                                                        required
                                                    >
                                                        <option value="pcs">
                                                            pcs
                                                        </option>
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
                                        <div className="col-11 text-end mt-2">
                                            <button
                                                type="button"
                                                className={`btn btn-success ${
                                                    selectedProducts == "" ||
                                                    selectedStockQuantity <= 0
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

                                    {/* Cart component */}
                                    <ProductCart
                                        cartItems={cartItems}
                                        addProductToCard={addProductToCard}
                                        deleteItem={deleteItem}
                                        totalProductPriceHandler={
                                            totalProductPriceHandler
                                        }
                                    />
                                </>
                            )}
                        </>
                    )}
                </SaleContext.Consumer>
            </>
        );
    }
}

import React, { Component } from 'react'

export default class ProductCart extends Component {
    constructor(props) {
        super(props)

    }
    render() {
      const { cartItems, deleteItem, totalProductPriceHandler } = this.props;
    return (
        <>
            <div className="row mb-1">
                <div className="col-12">
                    <div className="mb-3 table-responsive">
                        <table className="table custom-table table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">SL</th>
                                    <th scope="col">Product name</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Price</th>
                                    {/* <th scope="col">Purchase price</th> */}
                                    <th scope="col">Line total</th>
                                    <th
                                        scope="col"
                                        className="print-none text-end"
                                    >
                                        Action
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                {cartItems.map((item, index) => (
                                    <tr key={index}>
                                        <th scope="row"> {index + 1}.</th>
                                        <td>
                                            {item?.product?.name || item.name}
                                            <input
                                                type="hidden"
                                                name="product_ids[]"
                                                value={
                                                    item?.product_id || item.id
                                                }
                                                readOnly
                                            />
                                        </td>
                                        <td>
                                            {parseFloat(item.quantity)}{" "}
                                            {item?.qty_type ||
                                                item.quantityType}
                                            <input
                                                type="hidden"
                                                name="quantities[]"
                                                value={item.quantity}
                                                readOnly
                                            />
                                            <input
                                                type="hidden"
                                                name="qty_types[]"
                                                value={
                                                    item?.qty_type ||
                                                    item.quantityType
                                                }
                                                readOnly
                                            />
                                        </td>
                                        <td>
                                            {/* {parseFloat(item.purchasePrice)} */}
                                            {Number.parseFloat(
                                                item?.salePrice ||
                                                    item.sale_price
                                            ).toFixed(2)}
                                            <input
                                                type="hidden"
                                                name="sale_prices[]"
                                                value={
                                                    item?.salePrice ||
                                                    item.sale_price
                                                }
                                                readOnly
                                            />
                                            <input
                                                type="hidden"
                                                name="old_purchase_prices[]"
                                                value={item?.oldPurchasePrice || item.purchase_price}
                                                readOnly
                                            />
                                        </td>

                                        <td>
                                            {/* {parseFloat(
                                                    item.salePrice *
                                                        item.quantity
                                                )} */}
                                            {Number.parseFloat(
                                                item?.salePrice *
                                                    item?.quantity ||
                                                    item.sale_price *
                                                        item.quantity
                                            ).toFixed(2)}
                                        </td>
                                        <td className="text-end">
                                            {/* <button
                                                type="button"
                                                className="btn btn-outline-success btn-sm me-2"
                                                onClick={() =>
                                                    editItem(cartItems)
                                                }
                                            >
                                                <i className="bi bi-pencil-square"></i>
                                            </button> */}

                                            <button
                                                type="button"
                                                className="btn btn-danger btn-sm"
                                                onClick={() =>
                                                    deleteItem(
                                                        index,
                                                        totalProductPriceHandler
                                                    )
                                                }
                                            >
                                                <i className="bi bi-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                <tr>
                                    {cartItems.length === 0 && (
                                        <th colSpan="5" className="text-center">
                                            Cart list is empty.
                                        </th>
                                    )}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </>
    );
  }
}

import React, { Component } from 'react'
import { createRoot } from "react-dom/client";
import axios from "axios";

export default class GetSubcategoriesByCategory extends Component {
    constructor(props) {
        super(props);

        this.categories = JSON.parse(this.props.categories);

        this.state = {
            subcategories: [],
            selectedExpense: JSON.parse(this.props.expense),
            selectedSubcategoryId: "",
            errors: JSON.parse(this.props.errors),
        };

    }

    componentDidMount() {
        this.getSubcategories(
            this.state.selectedExpense.expense_category_id,
            "edit"
        );
    }

    getSubcategoryHandler = (e) => {
        this.getSubcategories(e.target.value);
    };

    getSubcategories = (id) => {
        axios
            .post(baseURL + "/dashboard/axios/getSubcategoriesById", {
                category_id: id,
            })
            .then((response) => {
                // update state
                this.setState({
                    subcategories: response.data,
                });

                console.log(response.data);
            })
            .catch((reason) => {
                console.log(reason);
            });

        this.setState({
            selectedSubcategoryId:
                this.state.selectedExpense.expense_subcategory_id,
        });
    };

    subCategoryHandler = (e) => {
        this.setState({
            selectedSubcategoryId: e.target.value,
        });
    };

    render() {
        return (
            <>
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="category"
                            className="mt-1 form-label required"
                        >
                            Category
                        </label>
                    </div>

                    <div className="col-5">
                        <select
                            type="text"
                            name="expense_category_id"
                            defaultValue={
                                this.state.selectedExpense.expense_category_id
                            }
                            onChange={this.getSubcategoryHandler}
                            className="form-control"
                            id="category"
                            required
                        >
                            <option value="">-- Choose one --</option>
                            {this.categories.map((category, index) => (
                                <option value={category.id} key={index}>
                                    {category.name}
                                </option>
                            ))}
                        </select>

                        {/* error */}
                        <small className="text-danger">
                            {Object.keys(this.state.errors).length > 0
                                ? this.state.errors.expense_category_id[0]
                                : ""}
                        </small>
                    </div>
                </div>

                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="subcategory"
                            className="mt-1 form-label required"
                        >
                            Subcategory
                        </label>
                    </div>

                    <div className="col-5">
                        <select
                            type="text"
                            name="expense_subcategory_id"
                            value={this.state.selectedSubcategoryId}
                            onChange={this.subCategoryHandler}
                            className="form-control"
                            id="subcategory"
                            required
                        >
                            <option value="">-- Choose one --</option>
                            {this.state.subcategories.map(
                                (subcategory, index) => (
                                    <option value={subcategory.id} key={index}>
                                        {subcategory.name}
                                    </option>
                                )
                            )}
                        </select>

                        {/* error */}
                        <small className="text-danger">
                            {Object.keys(this.state.errors).length > 0
                                ? this.state.errors.expense_subcategory_id[0]
                                : ""}
                        </small>
                    </div>
                </div>
            </>
        );
    }
}


// DOM element
if (document.getElementById("get-subcategories-by-category")) {
    // find element by id
    const element = document.getElementById("get-subcategories-by-category");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<GetSubcategoriesByCategory {...props} />);
}

import React, { Component } from 'react';
import { createRoot } from "react-dom/client";


export default class EmployeeSalary extends Component {
    constructor(props) {
        super(props);

        this.employees = JSON.parse(this.props.employees);
        this.cashes = JSON.parse(this.props.cashes);
        this.oldSalary = JSON.parse(this.props.oldSalary);

        this.state = {
            selectedEmployeeDetails: {},
            selectedEmployeeId:this.oldSalary ? this.oldSalary.employee_id : this.props.selectedEmployeeId,
        };
    }

    componentDidMount() {
        if (this.state.selectedEmployeeId) {
            this.getEmployeeDetailHandler(this.state.selectedEmployeeId);
        }
    }

    getEmployeeDetailHandler = (employee_id) => {
        const selectedEmployee = this.employees.find((employee) => {
            return employee.id === Number(employee_id);
        });
        this.setState({
            selectedEmployeeDetails: selectedEmployee,
        });

        // console.log(this.state.selectedEmployeeDetails);
    }

    render() {
       let selectedMonth = this.props.selectedMonth ? new Date(this.props.selectedMonth + " 02").toISOString().slice(0, 7):"";
        return (
            <>
                {/* select employee start */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="employee_id"
                            className="mt-1 form-label required"
                        >
                            Select employee
                        </label>
                    </div>

                    <div className="col-5">
                        <select
                            name="employee_id"
                            defaultValue={this.state.selectedEmployeeId}
                            // onChange={this.getEmployeeDetailHandler}
                            onChange={(e) =>
                                this.getEmployeeDetailHandler(e.target.value)
                            }
                            className="form-select"
                            id="employee_id"
                            required
                        >
                            <option defaultValue={""}> -- Choose one --</option>
                            {this.employees.map((employee, index) => (
                                <option value={employee.id} key={index}>
                                    {employee.name}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
                {/* select employee end  */}

                {/* Salary month start */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="month"
                            className="mt-1 form-label required"
                        >
                            Salary of
                        </label>
                    </div>

                    <div className="col-5">
                        <input
                            type="month"
                            name="salary_month"
                            // defaultValue={this.props.month}
                            defaultValue={
                                this.oldSalary
                                    ? this.props.month
                                    : selectedMonth
                            }
                            className="form-control"
                            id="month"
                            required
                        />
                    </div>
                </div>
                {/* Salary month end  */}

                {/* Salary date start  */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="date"
                            className="mt-1 form-label required"
                        >
                            Given date
                        </label>
                    </div>

                    <div className="col-5">
                        <input
                            type="date"
                            name="given_date"
                            defaultValue={
                                // this.oldSalary ? this.oldSalary.given_date : ""
                                this.oldSalary
                                    ? this.oldSalary.given_date
                                    : new Date().toISOString().slice(0, 10)
                            }
                            className="form-control"
                            id="date"
                            required
                        />
                    </div>
                </div>
                {/* Salary date end */}

                {/* Basic salary start */}
                <div className="mb-3 row">
                    <div className="col-2 ">
                        <label
                            htmlFor="basic-salary"
                            className="mt-1 form-label required"
                        >
                            Basic Salary
                        </label>
                    </div>
                    <div className="col-5">
                        <div className="input-group">
                            <div className="col-5">
                                <select
                                    name="payment_type"
                                    defaultValue={
                                        this.oldSalary
                                            ? this.oldSalary.payment_type
                                            : ""
                                    }
                                    className="form-select"
                                    required
                                >
                                    <option value="cash">Cash</option>
                                </select>
                            </div>
                            <input
                                type="number"
                                name="basic_salary"
                                defaultValue={
                                    this.oldSalary
                                        ? this.oldSalary["basic_salary"].amount
                                        : this.state.selectedEmployeeDetails
                                              .basic_salary
                                }
                                className="form-control"
                                id="basic-salary"
                                placeholder="0.00"
                                required
                                readOnly
                            />
                        </div>
                    </div>
                </div>
                {/* Basic salary end */}

                {/* cash select */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label
                            htmlFor="cash_id"
                            className="mt-1 form-label"
                        ></label>
                    </div>

                    <div className="col-5">
                        <select
                            name="cash_id"
                            className="form-select"
                            defaultValue={
                                this.oldSalary ? this.oldSalary.cash_id : ""
                            }
                            id="cash-id"
                        >
                            {this.cashes.map((cash, index) => (
                                <option value={cash.id} key={index}>
                                    {cash.cash_name}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
                {/* cash select end */}

                {/* Bonus start */}
                <div className="mb-3 row">
                    <div className="col-2 ">
                        <label htmlFor="bonus" className="mt-1 form-label">
                            Bonus
                        </label>
                    </div>
                    <div className="col-5">
                        <input
                            type="number"
                            name="bonus"
                            defaultValue={
                                this.oldSalary
                                    ? this.oldSalary["bonus"].amount
                                    : ""
                            }
                            className="form-control"
                            id="bonus"
                            placeholder="0.00"
                        />
                    </div>
                </div>
                {/* Basic salary end */}

                {/* Installment start */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label htmlFor="advance" className="mt-1 form-label">
                            Advanced amount
                        </label>
                    </div>

                    <div className="col-5">
                        <input
                            type="number"
                            name="advance_paid_amount"
                            defaultValue={
                                this.oldSalary
                                    ? this.oldSalary.advance_paid_amount
                                    : this.state.selectedEmployeeDetails
                                          .total_advance_due
                            }
                            className="form-control"
                            id="advance_paid_amount"
                            placeholder="0.00"
                            readOnly
                        />
                    </div>
                </div>
                {/* Installment end  */}

                {/* Diduction start */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label htmlFor="deduction" className="mt-1 form-label">
                            Deductions
                        </label>
                    </div>

                    <div className="col-5">
                        <input
                            type="number"
                            name="deduction"
                            defaultValue={
                                this.oldSalary
                                    ? this.oldSalary["deduction"].amount
                                    : ""
                            }
                            className="form-control"
                            id="deduction"
                            placeholder="0.00"
                        />
                    </div>
                </div>
                {/* Diduction end  */}

                {/* Note start */}
                <div className="mb-3 row">
                    <div className="col-2">
                        <label htmlFor="note" className="mt-1 form-label">
                            Note
                        </label>
                    </div>

                    <div className="col-5">
                        <textarea
                            name="note"
                            defaultValue={
                                this.oldSalary ? this.oldSalary.note : ""
                            }
                            className="form-control"
                            id="note"
                            rows="3"
                            placeholder="Optional"
                        ></textarea>
                    </div>
                </div>
                {/* Note end */}
            </>
        );
    }
}


// DOM element
if (document.getElementById("create-employee-salary")) {
    // find element by id
    const element = document.getElementById("create-employee-salary");
    const root = createRoot(element);

    const props = Object.assign({}, element.dataset);

    root.render(<EmployeeSalary {...props} />);
}



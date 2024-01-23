import React from 'react';

function TimeslotItem({ time, onChange, available, value }) {
    return (
        <div className={`flex items-center ps-2 border border-gray-300 rounded h-fit ${available ? 'bg-white' : 'cursor-not-allowed'}`}>
            <input
                disabled={!available}
                id={`time-${time}`}
                type="radio"
                name="time"
                value={time}
                checked={value && value === time}
                onChange={onChange}
                className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 focus:ring-2"
            />
            <label
                htmlFor={`time-${time}`}
                className="w-full py-2 ms-1 text-sm font-medium text-gray-900"
            >
                {time}
            </label>
        </div>
    );
}

export default TimeslotItem;
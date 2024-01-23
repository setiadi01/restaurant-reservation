import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, usePage } from '@inertiajs/react';
import { format } from 'date-fns';

export default function WalkInReservation({ auth, reservations }) {
    const { flash } = usePage().props
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Reservations</h2>}
        >
            <Head title="Reservations" />

            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    {flash.success && (
                        <div className="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            <span className="font-medium">Success!</span> Successfully booked
                        </div>
                    )}
                    <div className="mb-2">
                        <a href={route('reservations.create')} className="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            Add Reservation
                        </a>
                    </div>
                    <div className="relative overflow-x-auto">
                        <table className="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead className="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" className="px-6 py-3">
                                        Date
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Table
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Name
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Email
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Phone
                                    </th>
                                    <th scope="col" className="px-6 py-3">
                                        Special Request
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                {reservations.map(reservation => (
                                    <tr key={reservation.id} className="bg-white border-b">
                                        <td className="px-6 py-4 text-gray-900">
                                            {format(new Date(`${reservation.date} ${reservation.time}`), 'dd/MM/yyyy HH:mm')}
                                        </td>
                                        <td className="px-6 py-4 text-gray-900">Table {reservation.table.number}</td>
                                        <td className="px-6 py-4 text-gray-900">{reservation.name}</td>
                                        <td className="px-6 py-4 text-gray-900">{reservation.email}</td>
                                        <td className="px-6 py-4 text-gray-900">{reservation.phone ?? '-'}</td>
                                        <td className="px-6 py-4 text-gray-900">{reservation.special_request ?? '-'}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </AuthenticatedLayout>
    );
}

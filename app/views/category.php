<div class="container mx-auto p-4">
  <div class="overflow-x-auto">
    <table class="min-w-full bg-white shadow-md rounded-lg grid grid-cols-12">
      <thead class="bg-gray-100 border-b col-start-1 col-end-13 ">
        <tr class="grid grid-cols-12">
          <th class="col-span-8 text-left py-3 px-6 font-semibold text-gray-700">Category Title</th>
          <th class="col-start-10 col-span-3 justify-self-start text-right py-3 px-6 font-semibold text-gray-700">Action</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-200 col-start-1 col-end-13">
        <!-- Repeat this TR for each row -->
        <tr class="grid grid-cols-12">
          <td class="col-span-8 py-4 px-6 text-gray-600">Category Title 1</td>
          <td class="col-start-10 col-span-3 justify-self-start py-4 px-6 text-right space-x-2">
            <a href="#" class="bg-blue-500 text-white px-3 py-2 rounded hover:bg-blue-600">View</a>
            <a href="#" class="bg-yellow-500 text-white px-3 py-2 rounded hover:bg-yellow-600">Edit</a>
            <form action="#" method="POST" class="inline">
              <button type="submit" class="bg-red-500 text-white px-3 py-2 rounded hover:bg-red-600">Delete</button>
            </form>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</div>

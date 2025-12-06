<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instructor Sign Up</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

  <div class="bg-white shadow-lg rounded-2xl w-full max-w-xl p-8">
    <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Instructor Sign Up</h2>

    <form action="{{ route('instructor.register') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
      @csrf


      <!-- Area of Expertise -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Area of Expertise</label>
          <input type="text" name="area_of_expertise" placeholder="e.g., Web Development, Data Science" value="{{ old('area_of_expertise') }}" required
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          @error('area_of_expertise')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Qualification -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Qualification</label>
          <input type="text" name="qualification" placeholder="e.g., MSc in Computer Science" value="{{ old('qualification') }}" required
                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">
          @error('qualification')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Short Bio -->
        <div>
          <label class="block text-gray-700 font-medium mb-1">Short Bio</label>
          <textarea name="short_bio" rows="3" placeholder="Write a short introduction about yourself" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 focus:outline-none">{{ old('short_bio') }}</textarea>
          @error('short_bio')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>


      <!-- Submit -->
      <button type="submit"
              class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition">
        Submit Application
      </button>
    </form>
  </div>

</body>
</html>

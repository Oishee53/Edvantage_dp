<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - EDVANTAGE</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@200;300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <style>
        * {
            font-family: 'Montserrat', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    <!-- Include Header Component -->
    @include('layouts.header')
    
    <!-- Main Profile Container -->
    <div class="pt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <!-- Left Sidebar -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 sticky top-24">
                        <!-- Profile Header -->
                        <div class="text-center mb-6">
                            <div class="w-28 h-28 mx-auto mb-4 bg-teal-600 rounded-full flex items-center justify-center shadow-lg">
                                <i class="fas fa-user text-white text-5xl"></i>
                            </div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->name }}</h1>
                            <p class="text-sm text-gray-600">{{ $user->field }} Enthusiast</p>
                        </div>
                        
                        <!-- Profile Actions -->
                        <div class="space-y-3">
                            <button class="w-full px-4 py-2.5 border-2 border-teal-600 text-teal-600 rounded-lg hover:bg-teal-50 transition-colors font-medium flex items-center justify-center gap-2">
                                <i class="fas fa-share-alt"></i>
                                Share profile link
                            </button>
                            <button class="w-full text-sm text-gray-600 hover:text-teal-600 transition-colors underline">
                                Update profile visibility
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Right Main Content -->
                <div class="lg:col-span-3 space-y-8">
                    <!-- Personal Information Section -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-user-circle text-teal-600 text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Personal Information</h2>
                        </div>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Manage your personal information and account details. Keep your profile up to date to get the most out of your learning experience.
                        </p>
                        
                        <div class="space-y-4">
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-600 hover:shadow-md transition-all">
                                <div class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Full Name</div>
                                <div class="text-base font-medium text-gray-900">{{ $user->name }}</div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-600 hover:shadow-md transition-all">
                                <div class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Email Address</div>
                                <div class="text-base font-medium text-gray-900">{{ $user->email }}</div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-600 hover:shadow-md transition-all">
                                <div class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Phone Number</div>
                                <div class="text-base font-medium text-gray-900">{{ $user->phone ?? 'Not provided' }}</div>
                            </div>
                            
                            <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-600 hover:shadow-md transition-all">
                                <div class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Field of Interest</div>
                                <div class="text-base font-medium text-gray-900">{{ $user->field }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Information Section -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8">
                        <div class="flex items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                            <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                <i class="fas fa-cog text-teal-600 text-xl"></i>
                            </div>
                            <h2 class="text-2xl font-bold text-gray-900">Account Information</h2>
                        </div>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            View your account status and membership details. Your account information helps us provide you with personalized learning recommendations.
                        </p>
                        
                        <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-600 hover:shadow-md transition-all">
                            <div class="text-xs font-semibold text-teal-700 uppercase tracking-wide mb-1">Member Since</div>
                            <div class="text-base font-medium text-gray-900">{{ $user->created_at->format('F j, Y') }}</div>
                        </div>
                    </div>
                    
                    <!-- Bio Section -->
                    <div class="bg-white rounded-xl shadow-md border border-gray-200 p-6 md:p-8" x-data="{ 
                        editing: false, 
                        bioText: '{{ $user->bio ?? '' }}',
                        originalBio: '{{ $user->bio ?? '' }}',
                        showToast: false,
                        toggleEdit() {
                            this.editing = !this.editing;
                            if (this.editing) {
                                this.$nextTick(() => {
                                    this.$refs.bioTextarea.focus();
                                });
                            }
                        },
                        cancel() {
                            this.bioText = this.originalBio;
                            this.editing = false;
                        },
                        save() {
                            this.originalBio = this.bioText;
                            this.editing = false;
                            this.showToast = true;
                            setTimeout(() => { this.showToast = false; }, 3000);
                        }
                    }">
                        <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-teal-100 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-file-alt text-teal-600 text-xl"></i>
                                </div>
                                <h2 class="text-2xl font-bold text-gray-900">About Me</h2>
                            </div>
                            <button 
                                @click="toggleEdit()"
                                class="px-4 py-2 border-2 border-teal-600 text-teal-600 rounded-lg hover:bg-teal-50 transition-colors font-medium flex items-center gap-2">
                                <i class="fas" :class="editing ? 'fa-times' : 'fa-edit'"></i>
                                <span x-text="editing ? 'Cancel' : (bioText ? 'Edit Bio' : 'Add Bio')"></span>
                            </button>
                        </div>
                        
                        <p class="text-gray-600 mb-6 leading-relaxed">
                            Share a bit about yourself, your learning goals, and what motivates you. This helps others in the community get to know you better.
                        </p>
                        
                        <div class="bg-gray-50 rounded-lg p-6 border-l-4 border-teal-600">
                            <!-- Display Mode -->
                            <div x-show="!editing">
                                <p class="text-gray-900 leading-relaxed" 
                                   :class="bioText ? '' : 'text-gray-500 italic'"
                                   x-text="bioText || 'No bio added yet. Click \"Add Bio\" to tell others about yourself, your learning journey, and your goals.'">
                                </p>
                            </div>
                            
                            <!-- Edit Mode -->
                            <div x-show="editing" x-cloak>
                                <textarea 
                                    x-ref="bioTextarea"
                                    x-model="bioText"
                                    class="w-full min-h-[150px] px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-transparent resize-vertical"
                                    placeholder="Tell us about yourself, your learning goals, interests, and what motivates you to learn..."
                                    maxlength="500"
                                ></textarea>
                                <div class="flex items-center justify-between mt-3">
                                    <span class="text-sm text-gray-500">
                                        <span x-text="bioText.length"></span> / 500 characters
                                    </span>
                                    <div class="flex gap-2">
                                        <button 
                                            @click="save()"
                                            class="px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors font-medium flex items-center gap-2">
                                            <i class="fas fa-save"></i>
                                            Save Bio
                                        </button>
                                        <button 
                                            @click="cancel()"
                                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors font-medium flex items-center gap-2">
                                            <i class="fas fa-times"></i>
                                            Cancel
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Success Toast -->
                        <div x-show="showToast" 
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 translate-y-2"
                             class="fixed bottom-8 right-8 bg-green-600 text-white px-6 py-4 rounded-lg shadow-xl flex items-center gap-3 z-50"
                             style="display: none;">
                            <i class="fas fa-check-circle text-xl"></i>
                            <span class="font-medium">Bio saved successfully!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        [x-cloak] { display: none !important; }
    </style>
</body>
</html>

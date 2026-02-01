(function() {
    'use strict';
    
    // Prevent multiple injections
    if (window.MYVAULT_LOADED) {
        console.log('MyVault already loaded');
        return;
    }
    window.MYVAULT_LOADED = true;
    
    console.log('🔐 MyVault Autofill Helper Loaded!');
    
    // Listen for fill requests from popup
    window.addEventListener('message', function(event) {
        if (event.data && event.data.type === 'MYVAULT_FILL') {
            fillLoginForm(event.data.username, event.data.password);
        }
    });
    
    function fillLoginForm(username, password) {
        console.log('Filling form with username:', username);
        
        // Username/Email field selectors
        const usernameSelectors = [
            'input[type="email"]:not([type="hidden"])',
            'input[type="text"][name*="user" i]:not([type="hidden"])',
            'input[type="text"][name*="email" i]:not([type="hidden"])',
            'input[type="text"][name*="login" i]:not([type="hidden"])',
            'input[id*="user" i]:not([type="hidden"])',
            'input[id*="email" i]:not([type="hidden"])',
            'input[id*="login" i]:not([type="hidden"])',
            'input[placeholder*="email" i]:not([type="hidden"])',
            'input[placeholder*="username" i]:not([type="hidden"])',
            'input[autocomplete="username"]:not([type="hidden"])',
            'input[autocomplete="email"]:not([type="hidden"])',
            'input[name="email"]:not([type="hidden"])',
            'input[name="username"]:not([type="hidden"])',
            'input[name="user"]:not([type="hidden"])'
        ];
        
        // Find visible username field
        let usernameField = null;
        for (let selector of usernameSelectors) {
            const fields = document.querySelectorAll(selector);
            for (let field of fields) {
                if (isVisible(field)) {
                    usernameField = field;
                    break;
                }
            }
            if (usernameField) break;
        }
        
        // Find visible password field
        let passwordField = null;
        const passwordFields = document.querySelectorAll('input[type="password"]:not([type="hidden"])');
        for (let field of passwordFields) {
            if (isVisible(field)) {
                passwordField = field;
                break;
            }
        }
        
        // Fill the fields
        let filled = false;
        
        if (usernameField) {
            setNativeValue(usernameField, username);
            console.log('✓ Username filled');
            filled = true;
        } else {
            console.warn('⚠ Username field not found');
        }
        
        if (passwordField) {
            setNativeValue(passwordField, password);
            console.log('✓ Password filled');
            filled = true;
        } else {
            console.warn('⚠ Password field not found');
        }
        
        // Show notification
        if (filled) {
            showNotification('✓ Credentials filled successfully!', 'success');
        } else {
            showNotification('⚠ Login form not found on this page', 'warning');
        }
    }
    
    function isVisible(element) {
        if (!element) return false;
        
        const style = window.getComputedStyle(element);
        return element.offsetParent !== null && 
               style.display !== 'none' && 
               style.visibility !== 'hidden' && 
               style.opacity !== '0' &&
               element.type !== 'hidden';
    }
    
    function setNativeValue(element, value) {
        // For React/Vue forms - trigger native setter
        const nativeInputValueSetter = Object.getOwnPropertyDescriptor(
            window.HTMLInputElement.prototype,
            'value'
        ).set;
        
        if (nativeInputValueSetter) {
            nativeInputValueSetter.call(element, value);
        } else {
            element.value = value;
        }
        
        // Trigger all possible events
        const events = [
            new Event('input', { bubbles: true }),
            new Event('change', { bubbles: true }),
            new Event('keydown', { bubbles: true }),
            new Event('keyup', { bubbles: true }),
            new Event('blur', { bubbles: true })
        ];
        
        events.forEach(event => element.dispatchEvent(event));
        
        // Focus the field
        element.focus();
    }
    
    function showNotification(message, type) {
        // Remove existing notification
        const existing = document.getElementById('myvault-notification');
        if (existing) existing.remove();
        
        // Color based on type
        const colors = {
            success: '#28a745',
            warning: '#ffc107',
            error: '#dc3545'
        };
        
        const bgColor = colors[type] || colors.success;
        
        // Create notification
        const notification = document.createElement('div');
        notification.id = 'myvault-notification';
        notification.innerHTML = message;
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${bgColor};
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.3);
            z-index: 2147483647;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Arial, sans-serif;
            font-size: 14px;
            font-weight: 500;
            animation: slideIn 0.3s ease-out;
        `;
        
        // Add animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
        
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            notification.style.transition = 'opacity 0.5s, transform 0.5s';
            notification.style.opacity = '0';
            notification.style.transform = 'translateX(400px)';
            setTimeout(() => notification.remove(), 500);
        }, 3000);
    }
    
    console.log('✓ MyVault ready! Open bookmarklet popup to fill credentials.');
})();
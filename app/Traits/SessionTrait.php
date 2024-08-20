<?php

namespace App\Traits;

/**
 * SessionTrait
 *
 * A trait to handle session operations in a modular and reusable manner.
 * This trait supports nested session keys and common session tasks.
 */
trait SessionTrait {
  /**
   * Start the session if not already started.
   */
  public function startSession(): void {
    if (session_status() === PHP_SESSION_NONE) {
      session_start();
    }
  }

  /**
   * Get a session value.
   *
   * @param string|array $key The session key or an array of nested keys.
   * @param mixed $default The default value to return if the key does not exist.
   * @return mixed The session value or default if not found.
   */
  public function getSession($key, $default = null) {
    $this->startSession();

    if (is_array($key)) {
      return $this->getNestedValue($_SESSION, $key, $default);
    }

    return $_SESSION[$key] ?? $default;
  }

  /**
   * Set a session value.
   *
   * @param string|array $key The session key or an array of nested keys.
   * @param mixed $value The value to set.
   */
  public function setSession($key, $value): void {
    $this->startSession();

    if (is_array($key)) {
      $this->setNestedValue($_SESSION, $key, $value);
    } else {
      $_SESSION[$key] = $value;
    }
  }

  /**
   * Check if a session key exists.
   *
   * @param string|array $key The session key or an array of nested keys.
   * @return bool True if the session key exists, false otherwise.
   */
  public function hasSession($key): bool {
    $this->startSession();

    if (is_array($key)) {
      return $this->hasNestedValue($_SESSION, $key);
    }

    return isset($_SESSION[$key]);
  }

  /**
   * Remove a session value.
   *
   * @param string|array $key The session key or an array of nested keys.
   */
  public function removeSession($key): void {
    $this->startSession();

    if (is_array($key)) {
      $this->removeNestedValue($_SESSION, $key);
    } else {
      unset($_SESSION[$key]);
    }
  }

  /**
   * Clear all session data.
   */
  public function clearSession(): void {
    $this->startSession();
    session_unset();
  }

  /**
   * Destroy the session completely.
   */
  public function destroySession(): void {
    $this->startSession();
    session_destroy();
  }

  /**
   * Regenerate the session ID to prevent fixation attacks.
   *
   * @param bool $deleteOldSession Whether to delete the old session data.
   */
  public function regenerateSessionId(bool $deleteOldSession = true): void {
    $this->startSession();
    session_regenerate_id($deleteOldSession);
  }

  // --- Private Helper Methods ---

  /**
   * Recursively get a nested value from session data.
   *
   * @param mixed $data The current level of session data.
   * @param array $keys The array of keys to traverse.
   * @param mixed $default The default value if the key is not found.
   * @return mixed The nested value or default if not found.
   */
  private function getNestedValue($data, array $keys, $default) {
    foreach ($keys as $key) {
      if (is_array($data) && array_key_exists($key, $data)) {
        $data = $data[$key];
      } elseif (is_object($data) && property_exists($data, $key)) {
        $data = $data->$key;
      } else {
        return $default; // Key not found, return default
      }
    }

    return $data;
  }

  /**
   * Recursively set a nested value in session data.
   *
   * @param mixed $data The current level of session data (passed by reference).
   * @param array $keys The array of keys to traverse.
   * @param mixed $value The value to set.
   */
  private function setNestedValue(&$data, array $keys, $value): void {
    foreach ($keys as $key) {
      if (is_array($data)) {
        if (!isset($data[$key]) || !is_array($data[$key])) {
          $data[$key] = [];
        }
        $data = &$data[$key];
      } elseif (is_object($data)) {
        if (!property_exists($data, $key) || !is_object($data->$key)) {
          $data->$key = new \stdClass();
        }
        $data = &$data->$key;
      } else {
        return; // Invalid structure, exit
      }
    }

    $data = $value;
  }

  /**
   * Recursively check if a nested value exists in session data.
   *
   * @param mixed $data The current level of session data.
   * @param array $keys The array of keys to check.
   * @return bool True if all keys exist, false otherwise.
   */
  private function hasNestedValue($data, array $keys): bool {
    foreach ($keys as $key) {
      if (is_array($data) && array_key_exists($key, $data)) {
        $data = $data[$key];
      } elseif (is_object($data) && property_exists($data, $key)) {
        $data = $data->$key;
      } else {
        return false; // Key not found
      }
    }

    return true; // All keys exist
  }

  /**
   * Recursively remove a nested value from session data.
   *
   * @param mixed $data The current level of session data (passed by reference).
   * @param array $keys The array of keys to traverse.
   */
  private function removeNestedValue(&$data, array $keys): void {
    $key = array_shift($keys);

    if (is_array($data)) {
      if (isset($data[$key])) {
        if (empty($keys)) {
          unset($data[$key]);
        } else {
          $this->removeNestedValue($data[$key], $keys);
        }
      }
    } elseif (is_object($data)) {
      if (property_exists($data, $key)) {
        if (empty($keys)) {
          unset($data->$key);
        } else {
          $this->removeNestedValue($data->$key, $keys);
        }
      }
    }
  }
}

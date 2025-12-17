#!/bin/bash

# Colors for output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
RED='\033[0;31m'
NC='\033[0m' # No Color

API_URL="http://localhost:8000/api"

echo -e "${BLUE}=== NymoDental Authentication Test ===${NC}\n"

# Test all user logins
declare -a users=(
  "admin@nymodental.com:Admin User:ROLE_ADMIN"
  "dentist@nymodental.com:Dr. John Smith:ROLE_DENTIST"
  "hygienist@nymodental.com:Jane Doe:ROLE_HYGIENIST"
  "frontdesk@nymodental.com:Sarah Johnson:ROLE_FRONT_DESK"
  "patient@nymodental.com:Michael Brown:ROLE_PATIENT"
)

for user_data in "${users[@]}"; do
  IFS=':' read -r email name role <<< "$user_data"

  echo -e "${BLUE}Testing login for: ${name} (${role})${NC}"
  echo "Email: $email"

  # Login
  response=$(curl -s -X POST "$API_URL/login" \
    -H "Content-Type: application/json" \
    -d "{\"email\":\"$email\",\"password\":\"password\"}")

  # Extract token
  token=$(echo "$response" | grep -o '"token":"[^"]*"' | cut -d'"' -f4)

  if [ ! -z "$token" ]; then
    echo -e "${GREEN}✓ Login successful${NC}"
    echo "Token: ${token:0:20}..."

    # Test /me endpoint
    me_response=$(curl -s -X GET "$API_URL/me" \
      -H "Authorization: Bearer $token")

    user_name=$(echo "$me_response" | grep -o '"name":"[^"]*"' | head -1 | cut -d'"' -f4)

    if [ ! -z "$user_name" ]; then
      echo -e "${GREEN}✓ /me endpoint working${NC}"
      echo "User: $user_name"
    else
      echo -e "${RED}✗ /me endpoint failed${NC}"
    fi

    # Test logout
    logout_response=$(curl -s -X POST "$API_URL/logout" \
      -H "Authorization: Bearer $token")

    if echo "$logout_response" | grep -q "Logout successful"; then
      echo -e "${GREEN}✓ Logout successful${NC}"
    else
      echo -e "${RED}✗ Logout failed${NC}"
    fi
  else
    echo -e "${RED}✗ Login failed${NC}"
  fi

  echo ""
done

echo -e "${BLUE}=== Test Complete ===${NC}"
